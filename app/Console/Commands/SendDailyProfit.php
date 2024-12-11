<?php

namespace App\Console\Commands;

use App\Jobs\SendDailyProfitJob;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDailyProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:daily-profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily profit who has active plan.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('Sending daily profit...');

        // checking if today is sat or sun
        if (Carbon::today()->isWeekend()) {
            info('Skipping. Today is weekend');
            return;
        }

        $userPlans = UserPlan::where('status', true)->get();

        // checking if ROI is enabled on this platform
        $admin = User::find(1);
        if ($admin->settings('stop_roi_for_all_accounts')) {
            info('ROI Is Stopped By Admin');
            return;
        }

        foreach ($userPlans as $userPlan) {
            // adding history
            SendDailyProfitJob::dispatch($userPlan);
        }
    }
}
