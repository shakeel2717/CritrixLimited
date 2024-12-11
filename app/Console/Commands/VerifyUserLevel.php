<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyUserLevel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:levels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify All Users Level and update their level';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verifying All Users Level');
        $users = User::whereHas('userPlans', function ($query) {
            $query->where('status', true);
        })->get();
    }
}
