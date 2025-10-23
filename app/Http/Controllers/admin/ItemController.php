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
use App\Enums\ItemShowInStore;
use App\Enums\ItemStatusEnum;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with(['category','unit'])->paginate(10);
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', CategoryStatusEnum::Active)->get();
        $units = Unit::where('status', UnitStatusEnum::Active)->get();
        $itemShows = ItemShowInStore::labels();
        $itemStatuses = ItemStatusEnum::labels();
        return view('admin.items.create', compact('categories', 'units', 'itemShows', 'itemStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $item = Item::create($request->validated());
        $item->uploadPhoto($request, 'photo', 'items', 'item_photo');
        $item->uploadGallery($request, 'gallery', 'items/gallery', 'item_gallery');
        return to_route('admin.items.index')->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::findOrFail($id);
        return view('admin.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::where('status', CategoryStatusEnum::Active)->get();
        $units = Unit::where('status', UnitStatusEnum::Active)->get();
        $itemShows = ItemShowInStore::labels();
        $itemStatuses = ItemStatusEnum::labels();
        $item = Item::findOrFail($id);
        return view('admin.items.edit', compact('item', 'categories', 'units', 'itemShows', 'itemStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->validated());
        $item->uploadPhoto($request, 'photo', 'items', 'item_photo');
        $item->uploadGallery($request, 'gallery', 'items/gallery', 'item_gallery');
        return to_route('admin.items.index')->with('success', 'Item updated successfully.');
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
