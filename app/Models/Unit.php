<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\UnitStatusEnum;

class Unit extends Model
{

    protected $table = 'units';
    public $timestamps = true;
    protected $fillable = array('name', 'status');

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
    protected function casts(): array
    {
        return [
            'status' => UnitStatusEnum::class
        ];
    }

}
