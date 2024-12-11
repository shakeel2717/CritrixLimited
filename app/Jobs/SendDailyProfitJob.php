<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPlan;
use Carbon\Carbon;

class SendDailyProfitJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public UserPlan $userPlan)
    {
        info('Sending daily profit construct...');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('Sending daily profit single job');

        // checking if this user is not pin
        if ($this->userPlan->user->type == 'pin') {
            info('Skipping ' . $this->userPlan->user->name . ' as it is a pin');

            return;
        }


        info('Sending daily profit to ' . $this->userPlan->user->name);

        $profit = $this->userPlan->plan->profit;
        // checking if this user cap is full
        if ($this->userPlan->user->remainingCap() < $profit) {
            info('Cap is full. Not sending daily profit to ' . $this->userPlan->user->name);
            return;
        }

        // checking if ROI is enabled for this user
        if (!$this->userPlan->user->roi_enabled) {
            info('ROI IS Stoped For: ' . $this->userPlan->user->name);
            return;
        }

        // checking if this user already get today profit
        $alreadyTransaction = Transaction::where('user_id', $this->userPlan->user->id)
            ->where('user_plan_id', $this->userPlan->id)
            ->whereDay('created_at', '=', Carbon::today())
            ->where('amount', $profit)
            ->count();

        info($alreadyTransaction);

        // checking if cap is remaining
        if ($this->userPlan->user->remainingCap() >= $profit) {
            if ($alreadyTransaction < 1) {
                // adding history
                $transaction = Transaction::create([
                    'user_id' => $this->userPlan->user->id,
                    'user_plan_id' => $this->userPlan->id,
                    'amount' => $profit,
                    'status' => 'approved',
                    'type' => 'daily profit',
                    'sum' => true,
                    'reference' => 'Daily profit from ' . $this->userPlan->plan->name . ' plan',
                ]);
            } else {
                info('Already sent daily profit to ' . $this->userPlan->user->name);
            }
        } else {
            info('Cap is remaining. Not sending daily profit to ' . $this->userPlan->user->name);
        }
    }
}
