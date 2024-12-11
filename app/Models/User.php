<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'email_verified_at',
        'status',
        'avatar',
        'referral_id',
        'type',
        'roi_enabled',
        'roi_withdraw',
        'fake',
        'role',
        'country',
        'phone',
        'stop_sale',
        'ip_address',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role == 'admin';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function balance()
    {
        $in = Transaction::where('user_id', $this->id)
            ->when(!$this->roi_withdraw, function ($query) {
                $query->where('type', '!=', 'daily profit');
            })
            ->where('sum', true)
            ->sum('amount');

        $out = Transaction::where('user_id', $this->id)->where('sum', false)->sum('amount');

        return $in - $out;
    }

    public function withdraw_balance()
    {
        if ($this->roi_withdraw) {
            $in = Transaction::where('user_id', $this->id)->where('payment_status', true)->where('type', '!=', 'deposit')->where('sum', true)->sum('amount');
        } else {
            $in = Transaction::where('user_id', $this->id)->where('payment_status', true)->whereNotIn('type', ['deposit', 'daily profit'])->where('sum', true)->sum('amount');
        }
        $out = Transaction::where('user_id', $this->id)->where('type', '!=', 'plan activation')->where('sum', false)->sum('amount');
        return $in - $out;
    }

    public function full_balance()
    {
        if ($this->roi_withdraw) {
            $in = Transaction::where('user_id', $this->id)->where('sum', true)->sum('amount');
        } else {
            $in = Transaction::where('user_id', $this->id)->where('type', '!=', 'daily profit')->where('sum', true)->sum('amount');
        }
        $out = Transaction::where('user_id', $this->id)->where('sum', false)->sum('amount');
        return $in - $out;
    }

    public function settings($key, $defalt = null)
    {
        $setting = SiteSetting::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }
        return $defalt ?? null;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }

    public function netowrkReward($networkCommission)
    {
        return $this->transactions->where('type', 'reward')->where('additional_type', 'Networking Reward')->where('amount', $networkCommission)->count();
    }


    public function daily_profits()
    {
        return $this->transactions->where('type', 'daily profit');
    }


    public function deposits()
    {
        return $this->hasMany(Transaction::class)->where('type', 'deposit');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function userPlans()
    {
        return $this->hasMany(UserPlan::class);
    }

    public function upliner()
    {
        return $this->hasOne(User::class, 'id', 'referral_id');
    }

    public function downline()
    {
        return $this->hasMany(User::class, 'referral_id', 'id');
    }

    public function allDownline($status = false)
    {
        $downline = collect();

        // Get the direct downline users
        if ($status == true) {
            $directDownline = $this->downline()->whereHas('userPlans', function ($query) {
                $query->where('status', true);
            })->get();
        } else {
            $directDownline = $this->downline;
        }

        // Recursively get the downline for each user
        foreach ($directDownline as $user) {
            // Add the user to the downline collection
            $downline->push($user);

            // Merge the user's own downline recursively, and pass the $status parameter
            $downline = $downline->merge($user->allDownline($status)); // Pass the status here
        }

        return $downline;
    }

    public function totalSalesOfDownline()
    {
        $totalSale = 0;
        foreach ($this->allDownline() as $referral) {
            if ($referral->stop_sale == false && $referral->type == 'normal') {
                $totalSale += $referral->investment();
            }
        }

        return $totalSale;
    }

    public function downlineTree()
    {
        $tree = [];

        // Get the user's direct downline
        $directDownline = $this->downline;

        // Loop through each downline user and get their downline recursively
        foreach ($directDownline as $user) {
            // Add each user with their own downline
            $tree[] = [
                'user' => $user,
                'downline' => $user->downlineTree(),
            ];
        }

        return $tree;
    }

    public function AllDownlineBusiness()
    {
        $totalBusiness = 0;
        foreach ($this->allDownline() as $downlineUser) {
            foreach ($downlineUser->userPlans() as $user_plan) {
                $totalBusiness += $user_plan->amount;
            }
        }

        return $totalBusiness;
    }

    public function networkingCap()
    {
        return $this->userPlans->where('status', true)->sum(function ($userPlan) {
            return $userPlan->plan->price * $userPlan->plan->total_return;
        });
    }


    public function todayNetworkingCap()
    {
        return $this->userPlans->where('status', true)->sum(function ($userPlan) {
            return $userPlan->plan->earning_cap;
        });
    }

    public function todayRemainingCap()
    {
        if ($this->investment() == 0) return 0;
        $in = $this->transactions()->where('type', '!=', 'deposit')->where('type', '!=', 'daily profit')->whereDate('created_at', Carbon::today())->where('sum', true)->sum('amount');
        $out = $this->transactions()->where('type', 'balance adjustment')->whereDate('created_at', Carbon::today())->where('sum', false)->sum('amount');
        return $this->todayNetworkingCap() - ($in - $out);
    }

    public function todayAlreadyReceivedCap()
    {
        if ($this->investment() == 0) return 0;
        $in = $this->transactions()->where('type', '!=', 'deposit')->where('type', '!=', 'daily profit')->whereDate('created_at', Carbon::today())->where('sum', true)->sum('amount');
        $out = $this->transactions()->where('type',  'balance adjustment')->whereDate('created_at', Carbon::today())->where('sum', false)->sum('amount');
        return $in - $out;
    }

    public function remainingCap()
    {
        if ($this->investment() == 0) return 0;
        $in = $this->transactions->where('type', '!=', 'deposit')->where('sum', true)->sum('amount');
        $out = $this->transactions->where('type',  'balance adjustment')->where('sum', false)->sum('amount');
        return $this->networkingCap() - ($in - $out);
    }

    public function alreadyReceivedCap()
    {
        if ($this->investment() == 0) return 0;
        $in = $this->transactions->where('type', '!=', 'deposit')->where('sum', true)->sum('amount');
        $out = $this->transactions()->where('type',  'balance adjustment')->where('sum', false)->sum('amount');
        return $in - $out;
    }

    public function myCap()
    {
        return ($this->alreadyReceivedCap() / $this->networkingCap()) * 100;
    }

    public function investment()
    {
        return $this->userPlans->where('status', true)->sum(function ($userPlan) {
            return $userPlan->plan->price;
        });
    }

    public function kyc()
    {
        return $this->hasOne(Kyc::class);
    }

    public function totalCommission()
    {
        $in = $this->transactions->where('type', 'commission')->sum('amount');
        $out = $this->transactions->where('type', 'balance adjustment')->sum('amount');
        return $in - $out;
    }
}
