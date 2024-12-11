<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'user_plan_id', 'payment_id', 'withdraw_id', 'amount', 'payment_status', 'status', 'sum', 'reference', 'type', 'additional_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class);
    }

    // transaction belongs to Plan throw userPlan table
    public function plan()
    {
        return $this->hasOneThrough(Plan::class, UserPlan::class , 'id', 'id', 'user_plan_id', 'plan_id');
    }

    public function withdraw()
    {
        return $this->belongsTo(Withdraw::class);
    }
}
