<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SafeTypeEnum;
use App\Enums\SafeStatusEnum;

class Safe extends Model
{
    protected $table = 'safes';
    public $timestamps = true;
    protected $fillable = array('name', 'balance', 'status', 'type', 'description');
    public function safeTransactions()
    {
        return $this->hasmany('App\Models\SafeTransaction');
    }
    protected $casts = [
        'type' => SafeTypeEnum::class,
        'status' => SafeStatusEnum::class
    ];
}
