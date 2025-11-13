<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StockManageService;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\WarehouseTransaction;
use App\Models\Item;
use App\Enums\WarehouseStatusEnum;
use App\Http\Requests\Admin\WarehouseRequest;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouse::withCount('items')->get();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehousesStatus = WarehouseStatusEnum::labels();
        return view('admin.warehouses.create', compact('warehousesStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WarehouseRequest $request)
    {
        Warehouse::create($request->validated());
        return to_route('admin.warehouses.index')->with('success', 'Warehouse created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $transactions = $warehouse->warehouseTransactions()
        ->with(['item'])
        ->paginate(10);
        return view('admin.warehouses.show', compact('warehouse', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehousesStatus = WarehouseStatusEnum::labels();
        return view('admin.warehouses.edit', compact('warehouse', 'warehousesStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WarehouseRequest $request, string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($request->validated());
        return to_route('admin.warehouses.index', compact('warehouse'))
        ->with('success', 'Warehouse updated successfully');
    }
    public function inventory($id)
    {
        $warehouse = Warehouse::with('items')->findOrFail($id);
        return view('admin.warehouses.inventory', compact('warehouse'));
    }
    public function updateInventory(Request $request, $id)
    {
        DB::beginTransaction();
        $warehouse = Warehouse::findOrFail($id);
        $request->validate([
            'item.*.quantity' => 'required|numeric|min:0',
        ]);
        foreach ($request->items as $id => $item) {
            $selectedItem = Item::findOrFail($id);
            $quantity = $item['quantity'];
            (new StockManageService())->adjustStock($selectedItem, $warehouse->id, $quantity);
        }
        DB::commit();
        return back()->with('success', 'Quantity updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        if ($warehouse->items()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete warehouse with associated items.'
            ]);
        }
        $warehouse->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Warehouse deleted successfully'
        ]);
    }
}
