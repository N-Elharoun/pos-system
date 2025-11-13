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
    use SoftDeletes;
    
    protected $table = 'clients';
    public $timestamps = true;


    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'email', 'phone', 'address', 'balance', 'status','registered_via');
    public function sales()
    {
        return $this->hasMany('App\Models\Sale');
    }
    public function clientAccountTransactions()
    {
        return $this->morphMany('App\Models\ClientAccountTransaction', 'reference');
    }
    protected function casts(): array
    {
        return [
            'status' => ClientstatusEnum::class,
            'registered_via' => ClientRegistrationEnum::class
        ];
    }
}
