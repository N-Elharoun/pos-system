<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseTransaction extends Model
{
    protected $fillable = [
        'transaction_type', 'quantity', 'quantity_after', 'warehouse_id','description'
    ];
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse', 'warehouse_id');
    }
    protected $casts = [
        'transaction_type' => \App\Enums\WarehouseTransactionTypeEnum::class,
    ];
}
