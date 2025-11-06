<?php

namespace App\Services;

use App\Enums\WarehouseTransactionTypeEnum;

class StockManageService
{
    public function initStock($item, $warehouseId, $initStock)
    {
        $item->warehouses()->attach($warehouseId, ['quantity' => $initStock]);
        $item->warehousetransactions()->create([
            'transaction_type' => WarehouseTransactionTypeEnum::Init,
            'warehouse_id' => $warehouseId,
            'quantity' => $initStock,
            'quantity_after' => $initStock,
            'description' =>  'Initial stock added to warehouse ID: ' . $warehouseId,
        ]);
    }
    public function decreaseStock($item, $warehouseId, $quantity, $reference = null)
    {
        $stock = $item->warehouses()->where('itemable_id', $warehouseId)->first();
        if (!$stock) {
            $this->initStock($item, $warehouseId, 0);
        }
        $item->warehouses()->where('itemable_id', $warehouseId)->decrement('quantity', $quantity);
        $item->warehouseTransactions()->create([
            'transaction_type' => WarehouseTransactionTypeEnum::Sub,
            'warehouse_id' => $warehouseId,
            'quantity' => $quantity * -1,
            'quantity_after' => $item->warehouses()->where('itemable_id', $warehouseId)->first()->pivot->quantity,
            'description' => 'Stock decreased from warehouse ID: '
            . $warehouseId . ($reference ? ', Reference ID: ' . $reference->id : ''),
        ]);
    }
}
