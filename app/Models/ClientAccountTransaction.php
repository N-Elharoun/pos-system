<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAccountTransaction extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'description',
        'balance_after',
        'client_id',
        'user_id',
        'reference',
    ];
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function reference()
    {
        return $this->morphTo();
    }
}
