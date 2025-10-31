<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Enums\ItemStatusEnum;

class StockController extends Controller
{
    public function lowStock(Request $request)
    {
        $minStock = $request->min_stock ;
        $query = Item::with('category', 'unit')->where('status', ItemStatusEnum::Active);
        if ($minStock) {
            $query = $query->where('quantity', '<=', $minStock);
        } else {
            $query = $query->whereColumn('quantity', '<=', 'minimum_stock');
            $minStock = $query->value('minimum_stock');
        }
        $items = $query->paginate(10);
        return view('admin.stocks.low', compact('items', 'minStock'));
    }
}
