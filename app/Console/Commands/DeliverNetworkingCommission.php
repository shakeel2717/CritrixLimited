<?php

namespace App\Console\Commands;

use App\Models\NetworkCommission;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;

class DeliverNetworkingCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deliver:networking-commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deliver networking commission to all Networking Members.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereHas('userPlans', function ($query) {
            $query->where('status', true);
        })->get();

        foreach ($users as $user) {
            $this->info('Checking Networking Commission for: ' . $user->username);
            $userAllCommission = $user->transactions->where('type', 'commission')->sum('amount');
            $this->info('Networking Commission: ' . $userAllCommission);
            // checking all commisssion if he has more commission then busienss
            $networkCommissions = NetworkCommission::get();
            foreach ($networkCommissions as $networkCommission) {
                // getting networking reward
                if ($userAllCommission >= $networkCommission->business) {
                    $this->info('Networking Reward going to assign: ' . $networkCommission);
                    $this->info('Delivering Networking Commission to: ' . $user->username);
                    $transaction = Transaction::firstOrCreate([
                        'user_id' => $user->id,
                        'amount' => $networkCommission->reward,
                        'status' => 'approved',
                        'type' => 'reward',
                        'additional_type' => 'Networking Reward',
                        'sum' => true,
                        'reference' => 'Networking Reward for Rank: ' . $networkCommission->name,
                    ]);

                    $this->info('Delivered Networking Commission to: ' . $user->username);
                } else {
                    $this->info('No Networking Commission to deliver to: ' . $user->username);
                }
            }
        }
    }
}
