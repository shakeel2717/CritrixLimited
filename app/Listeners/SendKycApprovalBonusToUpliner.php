<?php

namespace App\Listeners;

use App\Events\KycUserVerified;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendKycApprovalBonusToUpliner implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(KycUserVerified $event): void
    {
        info("SendKycApprovalBonusToUpliner: " . $event->user->name);

        // Fetch the user
        $user = $event->user;

        // Sending bonus to this user
        $bonus_amount = $user->settings('approval_bonus');
        if ($user->userPlans->count() == 0) {
            $transaction = Transaction::firstOrCreate([
                'user_id' => $user->id,
                'amount' => $bonus_amount,
                'status' => 'approved',
                'type' => 'approval bonus',
                'sum' => true,
                'payment_status' => false,
                'reference' => 'Approval Bonus',
            ]);
        }

        // Check if the user has an upliner
        if ($user->upliner) {
            $upliner = $user->upliner;
            $upliner_bonus_amount = $user->settings('approval_bonus_for_upliner');
            info('Bonus amount for upliner: ' . $upliner_bonus_amount);

            // Checking if upliner has no active plan
            if ($upliner->userPlans->count() == 0) {
                info("Upliner {$upliner->name} has no active plan");

                // Check if upliner qualifies for bonus
                if ($upliner->transactions()->where('type', 'approval bonus')->where('additional_type', 'bonus from downline')->count() < 8) {
                    $transaction = Transaction::firstOrCreate([
                        'user_id' => $upliner->id,
                        'amount' => $upliner_bonus_amount,
                        'status' => 'approved',
                        'type' => 'approval bonus',
                        'additional_type' => 'bonus from downline',
                        'payment_status' => false,
                        'sum' => true,
                        'reference' => 'Bonus from ' . $user->username . ' on approval',
                    ]);
                    info('Transaction added: ' . $transaction->id);
                } else {
                    info('Upliner already received approval bonus more than 8 times');
                }
            } else {
                info('Upliner not qualified for approval bonus: has active plan');
            }
        }
    }
}
