<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Enums\ItemStatusEnum;
use App\Enums\SafeStatusEnum;
use App\Enums\UnitStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Item;
use App\Models\Safe;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Http\Requests\Admin\SaleRequest;
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
        $validated = $request->validated();
        $total = 0 ;
        $discountAmount = 0;
        $remaining = 0 ;
        foreach ($validated['items'] as $item) {
            $id = $item['item_id'] ;
            $selectedItem = Item::find($id);
            $totalPrice = $selectedItem->price * $item['quantity'];
            $total += $totalPrice;

            $itemsData[$id] = [
                'unit_price'  => $selectedItem->price,
                'quantity'    => $item['quantity'],
                'total_price' => $totalPrice,
                'notes' => $item['notes']
            ];
            $selectedItem->decrement('quantity', $item['quantity']);
        }

        $discountValue = $validated['discount_value'] ;

        if ($validated['discount_type'] == DiscountTypeEnum::Percentage->value) {
            $discountAmount = ($discountValue / 100) * $total;
        } else {
            $discountAmount = $discountValue;
        }


        $net = $total - $discountAmount ;

        if ($validated['payment_type'] == PaymentTypeEnum::Cash->value) {
            $paid = $net ;
        } else {
            $paid = $validated['payment_amount'];
            $remaining = $net - $paid ;
        }
        $sale = Sale::create([
            "client_id" => $validated['client_id'],
            "user_id" => Auth::id(),
            "safe_id" => $validated['safe_id'],
            "total" => $total,
            "discount_value" => $discountAmount,
            "discount_type" => $validated['discount_type'],
            "net_amount" => $net,
            "paid_amount" => $paid,
            "remaining_amount" => $remaining,
            "invoice_number" => $validated['invoice_number'],
            "payment_type" => $validated['payment_type'],
        ]);
        $sale->items()->attach($itemsData);
        @dd($request->all());
    }
}
