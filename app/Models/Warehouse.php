<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'status');
    public function photo()
    {
        return $this->morphOne('App\Models\File', 'fileable')->where('usage', 'warehouse_photo');
    }
    public function items()
    {
        return $this->morphToMany('App\Models\Item', 'itemable')
        ->withPivot('quantity')->withTimestamps();
    }
    public function warehouseTransactions()
    {
        return $this->hasMany('App\Models\WarehouseTransaction', 'warehouse_id');
    }
    protected $casts = [
        'status' => \App\Enums\WarehouseStatusEnum::class,
    ];
}
