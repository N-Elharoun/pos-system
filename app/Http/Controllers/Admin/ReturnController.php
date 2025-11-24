<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Enums\SaleTypeEnum;
use App\Enums\ItemStatusEnum;
use App\Enums\SafeStatusEnum;
use App\Enums\UnitStatusEnum;
use App\Enums\WarehouseStatusEnum;
use App\Models\Client;
use App\Models\Item;
use App\Models\Safe;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Http\Requests\Admin\SaleRequest;
use App\Services\ClientService;
use App\Services\SafeService;
use App\Services\StockManageService;
use DB;
use App\Settings\AdvancedSettings;
use App\Settings\GeneralSettings;
use Auth;

class ReturnController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view_return')->only('index', 'show');
    //     $this->middleware('permission:create_return')->only('create', 'store');
    // }
    public function index()
    {
        $returns = Sale::with('client')->where('type', SaleTypeEnum::Return)->paginate(10);
        return view('admin.returns.index', compact('returns'));
    }
    public function show($id)
    {
        $return = Sale::with('items', 'client', 'user', 'safe')->where('type', SaleTypeEnum::Return)->findOrFail($id);
        return view('admin.returns.show', compact('return'));
    }
    public function create()
    {
        $clients = Client::all();
        $safes = Safe::where('status', SafeStatusEnum::Active)->get();
        $units = Unit::where('status', UnitStatusEnum::Active)->get();
        $items = Item::where('status', ItemStatusEnum::Active)->get();
        $warehouses = Warehouse::where('status', WarehouseStatusEnum::Active)->get();
        $settings = new AdvancedSettings();
        return view(
            'admin.returns.create',
            compact('clients', 'safes', 'units', 'items', 'warehouses', 'settings')
        );
    }
    public function store(SaleRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['type'] = SaleTypeEnum::Return->value ;
            $return = auth()->user()->sales()->create($data);
            $total = $this->attachItems($return, $request);
            $this->updateSale($return, $total, $request);
            $safeService = new SafeService();
            $safeService->outTransaction(
                $return,
                $return->paid_amount,
                'Return Payment, Invoice #: ' . $return->invoice_number
            );
            $clientService = new ClientService();
            $clientService->outerTransaction($return);
            DB::commit();
            return to_route('admin.returns.invoice', $return->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create return: ' . $e->getMessage());
        }
    }
    public function printInvoice(Sale $return)
    {
        $company = new GeneralSettings();

        // Generate PDF HTML
        $html = view('admin.returns.invoice', compact('return', 'company'))->render();

        // Clear old form inputs so Create page is empty
        session()->forget('_old_input');

        return response($html);
    }

    private function attachItems(Sale $return, SaleRequest $request): float
    {
        $total = 0;
        foreach ($request->items as $id => $item) {
            $selectedItem = Item::find($id);
            $totalPrice = $selectedItem->price * $item['quantity'];
            $total += $totalPrice;
            $return->items()->attach([
                $id => [
                    'unit_price'  => $selectedItem->price,
                    'quantity'    => $item['quantity'],
                    'total_price' => $totalPrice,
                    'notes' => $item['notes']
                ]
            ]);
            // $selectedItem->decrement('quantity', $item['quantity']);
            (new StockManageService())
            ->increaseStock($selectedItem, $request->warehouse_id, $item['quantity'], $return);
        }
        return $total;
    }
    private function calculateDiscount(SaleRequest $request, float $total): float
    {
        if ($request->discount_type == DiscountTypeEnum::Percentage->value) {
            $discount = $request->discount_value / 100 * $total;
        } else {
            $discount = $request->discount_value ?? 0;
        }
        return $discount;
    }
    private function updateSale(Sale $return, $total, SaleRequest $request)
    {
        $discount = $this->calculateDiscount($request, $total);
        $net = $total - $discount;
        if ($request->payment_type == PaymentTypeEnum::Debt->value) {
            $paid = $request->payment_amount > $net ? $net : $request->payment_amount;
        } else {
            $paid = $net;
        }
        $remaining = $net - $paid;
        $return->total = $total;
        $return->discount_value = $discount;
        $return->net_amount = $net;
        $return->paid_amount = $paid;
        $return->remaining_amount = $remaining;
        $return->save();
    }
}
