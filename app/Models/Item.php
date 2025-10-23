<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\ItemShowInStore;
use App\Enums\ItemStatusEnum;
use App\Traits\PhotoManagementTrait;

class Item extends Model
{
    use HasFactory;
    use PhotoManagementTrait;

    protected $table = 'items';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'item_code', 'description', 'price', 'quantity','category_id','unit_id',
    'status', 'is_shown_in_store', 'minimum_stock');

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function photo()
    {
        return $this->morphOne('App\Models\File', 'fileable')->where('usage', 'item_photo');
    }

    public function gallery()
    {
        return $this->morphMany('App\Models\File', 'fileable')->where('usage', 'item_gallery');
    }

    public function sales()
    {
        return $this->morphedByMany('App\Models\Sale', 'itemable');
    }

    public function returns()
    {
        return $this->morphedByMany('App\Models\SaleReturn', 'itemable');
    }
    protected function casts(): array
    {
        return [
            'is_shown_in_store' => ItemShowInStore::class,
            'status' => ItemStatusEnum::class
        ];
    }
}
