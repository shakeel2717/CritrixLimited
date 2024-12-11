<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RemoveFakeTransactionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info("Job is Started");

        // remove all users that created yesterday
        $users = User::where('fake', true)->where('created_at', '<', now()->subDays(1))->take(50)->get();

        foreach ($users as $user) {
            $user->delete();
        }

        info("Job is Ended");
    }
}
