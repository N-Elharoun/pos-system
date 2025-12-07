<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Http\Resources\V1\ItemResource;
use App\Enums\ItemShowInStoreEnum;
use App\Enums\ItemStatusEnum;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\Api\V1\ItemRequest;
use DB;
use App\Services\StockManageService;

class ItemController extends Controller
{
    use ApiResponseTrait;

    public $resourceName = ItemResource::class;

    public function index()
    {
        $items = Item::where([
            'status' => ItemStatusEnum::Active,
            'is_shown_in_store' => ItemShowInStoreEnum::Show
            ])
            ->paginate(10);
        return $this->paginatedResponseApi($items, 'Items retrieved successfully');
    }
    public function store(ItemRequest $request)
    {
        DB::beginTransaction();
        $data = $request->validated();
        $item = Item::create($data);
        $item->createPhoto($request, 'photo', 'items', 'item_photo');
        $item->createGallery($request, 'gallery', 'items/gallery', 'item_gallery');
        (new StockManageService())->initStock($item, $data['warehouse_id'], $data['quantity']);
        DB::commit();
        $item = $item->toResource($this->resourceName);
        return $this->apiSuccessMessage($item, 'Item created successfully');
    }
    public function show($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item = $item->toResource($this->resourceName);
            return $this->apiSuccessMessage($item, 'Item retrieved successfully');
        } else {
            return $this->apiErrorMessage('Item not found', 400);
        }
    }
    public function update(ItemRequest $request, string $id)
    {
        $item = Item::find($id);
        if ($item) {
            DB::beginTransaction();
            $data = $request->validated();
            $item->update($data);
            $item->updatePhoto($request, 'photo', 'items', 'item_photo');
            $item->updateGallery($request, 'gallery', 'items/gallery', 'item_gallery');
            (new StockManageService())->adjustStock($item, $data['warehouse_id'], $data['quantity']);
            $item = $item->toResource($this->resourceName);
            return $this->apiSuccessMessage($item, 'Item updated successfully');
        } else {
            return $this->apiErrorMessage('Item not found', 400);
        }
    }
    public function destroy(string $id)
    {
        $item = Item::find($id);
        if ($item) {
            if ($item->sales()->exists()) {
                return $this->apiErrorMessage('Cannot delete item with associated sales or returns.', 400);
            }
            $item->deletePhoto();
            $item->deleteGallery();
            $item->delete();
            return $this->apiSuccessMessage(null, 'Item deleted successfully');
        } else {
            return $this->apiErrorMessage('Item not found', 400);
        }
    }
}
