<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafeTransaction extends Model
{
    protected $table = 'safe_transactions';
    public $timestamps = true;
    protected $fillable = array('type', 'amount', 'description', 'balance_after', 'safe_id', 'user_id');

    public function safe()
    {
        return $this->belongsTo('App\Models\Safe');
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
