<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Enums\ItemStatusEnum;

class StockController extends Controller
{
    public function lowStock()
    {
        // Get all active items with relationships
        $items = Item::with(['category', 'unit', 'warehouses'])
            ->where('status', ItemStatusEnum::Active)
            ->get();

        // Attach total_stock and filter low-stock items
        $lowStockItems = $items->filter(function ($item) {
            $item->total_stock = $this->totalStock($item);
            return $item->total_stock <= $item->minimum_stock;
        });

        return view('admin.stocks.low', ['items' => $lowStockItems]);
    }

    // Helper function to calculate total stock for an item
    public function totalStock(Item $item): float
    {
        return $item->warehouses->sum(function ($warehouse) {
            return $warehouse->pivot->quantity ?? 0;
        });
    }
}
