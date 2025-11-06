<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Enums\ItemStatusEnum;
use App\Models\Warehouse;

class StockController extends Controller
{
    public function lowStock()
    {
        $items = Item::with(['category', 'unit', 'warehouses'])
            ->where('status', ItemStatusEnum::Active)
            ->paginate(10);
        foreach ($items as $item) {
            $item->total_stock = $item->warehouses->sum('pivot.quantity');
        }
        return view('admin.stocks.low', compact('items'));
    }
}
