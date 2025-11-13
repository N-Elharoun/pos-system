<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ItemRequest;
use App\Enums\CategoryStatusEnum;
use App\Enums\UnitStatusEnum;
use App\Enums\ItemShowInStoreEnum;
use App\Enums\ItemStatusEnum;
use App\Models\Warehouse;
use App\Enums\WarehouseStatusEnum;
use App\Services\StockManageService;
use DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with(['category','unit','warehouses'])->paginate(10);
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', CategoryStatusEnum::Active)->get();
        $units = Unit::where('status', UnitStatusEnum::Active)->get();
        $warehouses = Warehouse::where('status', WarehouseStatusEnum::Active)->get();
        $itemShows = ItemShowInStoreEnum::labels();
        $itemStatuses = ItemStatusEnum::labels();
        return view('admin.items.create', compact('categories', 'units', 'warehouses', 'itemShows', 'itemStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        DB::beginTransaction();
        try {
            $item = Item::create($request->validated());
            $item->createPhoto($request, 'photo', 'items', 'item_photo');
            $item->createGallery($request, 'gallery', 'items/gallery', 'item_gallery');
            (new StockManageService())->initStock($item, $request->warehouse_id, $request->quantity);
            DB::commit();
            return to_route('admin.items.index')->with('success', 'Item created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create item.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::with('warehouses')->findOrFail($id);
        if ($item->warehouses()->exists()) {
            $quantity = $item->warehouses()->where('item_id', $item->id)->first()->pivot->quantity;
        } else {
            $quantity = 0;
        }
        return view('admin.items.show', compact('item', 'quantity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::where('status', CategoryStatusEnum::Active)->get();
        $units = Unit::where('status', UnitStatusEnum::Active)->get();
        $itemShows = ItemShowInStoreEnum::labels();
        $itemStatuses = ItemStatusEnum::labels();
        return view(
            'admin.items.edit',
            compact('item', 'categories', 'units', 'itemShows', 'itemStatuses')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $item = Item::findOrFail($id);
            $item->update($request->validated());
            $item->updatePhoto($request, 'photo', 'items', 'item_photo');
            $item->updateGallery($request, 'gallery', 'items/gallery', 'item_gallery');
            DB::commit();
            return to_route('admin.items.index')->with('success', 'Item updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create item.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        if ($item->sales()->exists() || $item->returns()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete item with associated sales or returns.',
            ]);
        }
        $item->deletePhoto();
        $item->deleteGallery();
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Item deleted successfully'
            ]);
    }
}
