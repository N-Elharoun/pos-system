<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Enums\ItemStatusEnum;
use App\Enums\SafeStatusEnum;
use App\Enums\UnitStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Item;
use App\Models\Safe;
use App\Models\Unit;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Http\Requests\Admin\SaleRequest;
use App\Services\SafeService;
use DB;
use Auth;

class SaleController extends Controller
{
    public function create()
    {
        $clients = Client::all();
        $safes = Safe::where('status', SafeStatusEnum::Active)->get();
        $units = Unit::where('status', UnitStatusEnum::Active)->get();
        $items = Item::where('status', ItemStatusEnum::Active)->get();
        $discountTypes = DiscountTypeEnum::labels();
        $paymentTypes = PaymentTypeEnum::labels();
        return view(
            'admin.sales.create',
            compact('clients', 'safes', 'units', 'items', 'discountTypes', 'paymentTypes')
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
            $this->processClientAccountTransaction($sale);
            DB::commit();
            dd($request->all());
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }
    private function attachItems(Sale $sale, SaleRequest $request): float
    {
        $total = 0;
        foreach ($request->items as $id => $item) {
            $selectedItem = Item::find($id);
            $totalPrice = $selectedItem->price * $item['quantity'];
            $sale->items()->attach([
                $id => [
                    'unit_price'  => $selectedItem->price,
                    'quantity'    => $item['quantity'],
                    'total_price' => $totalPrice,
                    'notes' => $item['notes']
                ]
            ]);
            $selectedItem->decrement('quantity', $item['quantity']);
            $total += $totalPrice;
        }
        return $total;
    }
    private function calculateDiscount(SaleRequest $request, float $total): float
    {
        if ($request->discount_type == DiscountTypeEnum::Percentage->value) {
            $discount = $request->discount_value / 100 * $total;
        } else {
            $discount = $request->discount_value;
        }
        return $discount;
    }
    private function updateSale(Sale $sale, $total, SaleRequest $request)
    {
        $discount = $this->calculateDiscount($request, $total);
        $net = $total - $discount;
        if ($request->payment_type == PaymentTypeEnum::Debt->value) {
            $paid = $request->payment_amount;
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
    private function processClientAccountTransaction(Sale $sale): void
    {
        $net = $sale->net_amount;
        $paid = $sale->paid_amount;
        $balance = $net - $paid;

        if ($balance != 0) {
            $sale->client->increment('balance', $balance);
        }

        $sale->clientAccountTransaction()->create([
            'user_id' => Auth::id(),
            'client_id' => $sale->client_id,
            'credit' => $net,
            'debit' => $paid,
            'balance' => $balance,
            'description' => 'Sale Remaining Amount, Invoice #: ' . $sale->invoice_number,
            'balance_after' => $sale->client->fresh()->balance,
        ]);
    }
}
