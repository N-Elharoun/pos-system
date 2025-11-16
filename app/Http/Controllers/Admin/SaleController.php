<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Enums\ItemStatusEnum;
use App\Enums\SafeStatusEnum;
use App\Enums\UnitStatusEnum;
use App\Enums\WarehouseStatusEnum;
use App\Http\Controllers\Controller;
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
use Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('client')->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }
    public function show($id)
    {
        $sale = Sale::with('items', 'client', 'user', 'safe')->findOrFail($id);
        return view('admin.sales.show', compact('sale'));
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
            'admin.sales.create',
            compact('clients', 'safes', 'units', 'items', 'warehouses', 'settings')
        );
    }
    public function store(SaleRequest $request)
    {
        DB::beginTransaction();
        try {
            $sale = auth()->user()->sales()->create($request->validated());
            $total = $this->attachItems($sale, $request);
            $this->updateSale($sale, $total, $request);
            $safeService = new SafeService();
            $safeService->inTransaction(
                $sale,
                $sale->paid_amount,
                'Sale Payment, Invoice #: ' . $sale->invoice_number
            );
            $clientService = new ClientService();
            $clientService->inTransaction($sale);
            DB::commit();
            return to_route('admin.sales.index')->with('success', 'Sale created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create sale: ' . $e->getMessage());
        }
    }
    private function attachItems(Sale $sale, SaleRequest $request): float
    {
        $total = 0;
        foreach ($request->items as $id => $item) {
            $selectedItem = Item::find($id);
            $totalPrice = $selectedItem->price * $item['quantity'];
            $total += $totalPrice;
            $sale->items()->attach([
                $id => [
                    'unit_price'  => $selectedItem->price,
                    'quantity'    => $item['quantity'],
                    'total_price' => $totalPrice,
                    'notes' => $item['notes']
                ]
            ]);
            // $selectedItem->decrement('quantity', $item['quantity']);
            (new StockManageService())->decreaseStock($selectedItem, $request->warehouse_id, $item['quantity'], $sale);
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
    private function updateSale(Sale $sale, $total, SaleRequest $request)
    {
        $discount = $this->calculateDiscount($request, $total);
        $net = $total - $discount;
        if ($request->payment_type == PaymentTypeEnum::Debt->value) {
            $paid = $request->payment_amount > $net ? $net : $request->payment_amount;
        } else {
            $paid = $net;
        }
        $remaining = $net - $paid;
        $sale->total = $total;
        $sale->discount_value = $discount;
        $sale->net_amount = $net;
        $sale->paid_amount = $paid;
        $sale->remaining_amount = $remaining;
        $sale->save();
    }
}
