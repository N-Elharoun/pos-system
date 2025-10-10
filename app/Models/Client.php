<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\ClientRegistrationEnum;
use App\Enums\ClientStatusEnum;

class Client extends Model
{ 
    use HasFactory;
    protected $table = 'clients';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'email', 'phone', 'address', 'balance', 'status','registered_via');
     protected function casts(): array
    {
        return [
            'status' => ClientstatusEnum::class,
            'registered_via' => ClientRegistrationEnum::class
        ];
    }

}