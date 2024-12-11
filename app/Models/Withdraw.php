<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{

    protected $fillable = [
        "user_id",
        "amount",
        "status",
        "withdraw",
        "fees"
    ];
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
