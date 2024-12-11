<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'document_number',
        'document_type',
        'selfie',
        'front',
        'back',
        'address',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
