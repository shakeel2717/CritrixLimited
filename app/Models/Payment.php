<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'txn_id', 'amount', 'address', 'confirms_needed', 'checkout_url', 'status_url', 'qrcode_url', 'timeout', 'status'];

    public function user()
    {   
        return $this->belongsTo(User::class);
    }
}
