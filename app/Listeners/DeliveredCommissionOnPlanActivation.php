<?php

namespace App\Listeners;

use App\Events\UserPlanActivated;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeliveredCommissionOnPlanActivation implements ShouldQueue
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
    public function handle(UserPlanActivated $event): void
    {
        info("Delivered commission on plan activation for user {$event->transaction->user_id} and plan {$event->transaction->user_plan_id}");
        // checking if this user has valid upliner
        $user = User::find($event->transaction->user_id);
        // checking if this user has any real deposit
        if ($user->deposits->sum('amount') > 0) {
            info("User Deposit found for {$user->username} " . $user->deposits->sum('amount'));
            if ($user->upliner) {
                $upliner = $user->upliner;
                $commission_amount = $event->transaction->amount * $user->settings('level_1_commission') / 100;
                info('Commission amount: ' . $commission_amount);

                // checking overall netowrking cap
                if ($upliner->remainingCap() >= $commission_amount) {
                    info('Overall Cap is not full. sent commission to ' . $upliner->name);

                    // checking if this user daily cap is not reached
                    if ($upliner->todayRemainingCap() >= $commission_amount) {
                        info('Daily Cap is not full. sent commission to ' . $upliner->name);
                    } else {
                        info('Daily Cap is full. adjusting commission from account: ' . $upliner->name);
                        // adjusting commission
                        $diff = $commission_amount - $upliner->todayRemainingCap();
                        $diffTransaction = Transaction::firstOrCreate([
                            'user_id' => $upliner->id,
                            'user_plan_id' => $event->transaction->userPlan->id,
                            'amount' => $diff,
                            'status' => 'approved',
                            'type' => 'balance adjustment',
                            'sum' => false,
                            'reference' => 'Networking Daily Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                        ]);
                    }
                } else {
                    info('Overall Cap is full. adjusting commission from account: ' . $upliner->name);
                    // adjusting commission
                    $diff = $commission_amount - $upliner->remainingCap();
                    $diffTransaction = Transaction::firstOrCreate([
                        'user_id' => $upliner->id,
                        'user_plan_id' => $event->transaction->userPlan->id,
                        'amount' => $diff,
                        'status' => 'approved',
                        'type' => 'balance adjustment',
                        'sum' => false,
                        'reference' => 'Networking Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                    ]);
                }

                // adding commission
                $transaction = Transaction::firstOrCreate([
                    'user_id' => $upliner->id,
                    'user_plan_id' => $event->transaction->userPlan->id,
                    'amount' => $commission_amount,
                    'status' => 'approved',
                    'type' => 'commission',
                    'additional_type' => 'level 1 commission',
                    'sum' => true,
                    'reference' => 'level 1 commission from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                ]);
                info('Commission added: ' . $transaction->id);


                // level 2 commission
                if ($upliner->upliner) {
                    $upliner = $upliner->upliner;
                    $commission_amount = $event->transaction->amount * $user->settings('level_2_commission') / 100;
                    info('Commission amount: ' . $commission_amount);

                    // checking overall netowrking cap
                    if ($upliner->remainingCap() >= $commission_amount) {
                        info('Overall Cap is not full. sent commission to ' . $upliner->name);

                        // checking if this user daily cap is not reached
                        if ($upliner->todayRemainingCap() >= $commission_amount) {
                            info('Daily Cap is not full. sent commission to ' . $upliner->name);
                        } else {
                            info('Daily Cap is full. adjusting commission from account: ' . $upliner->name);
                            // adjusting commission
                            $diff = $commission_amount - $upliner->todayRemainingCap();
                            $diffTransaction = Transaction::firstOrCreate([
                                'user_id' => $upliner->id,
                                'user_plan_id' => $event->transaction->userPlan->id,
                                'amount' => $diff,
                                'status' => 'approved',
                                'type' => 'balance adjustment',
                                'sum' => false,
                                'reference' => 'Networking Daily Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                            ]);
                        }
                    } else {
                        info('Overall Cap is full. adjusting commission from account: ' . $upliner->name);
                        // adjusting commission
                        $diff = $commission_amount - $upliner->remainingCap();
                        $diffTransaction = Transaction::firstOrCreate([
                            'user_id' => $upliner->id,
                            'user_plan_id' => $event->transaction->userPlan->id,
                            'amount' => $diff,
                            'status' => 'approved',
                            'type' => 'balance adjustment',
                            'sum' => false,
                            'reference' => 'Networking Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                        ]);
                    }

                    // adding commission
                    $transaction = Transaction::firstOrCreate([
                        'user_id' => $upliner->id,
                        'user_plan_id' => $event->transaction->userPlan->id,
                        'amount' => $commission_amount,
                        'status' => 'approved',
                        'type' => 'commission',
                        'additional_type' => 'level 2 commission',
                        'sum' => true,
                        'reference' => 'level 2 commission from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                    ]);
                    info('Commission added: ' . $transaction->id);


                    // level 3 commission
                    if ($upliner->upliner) {
                        $upliner = $upliner->upliner;
                        $commission_amount = $event->transaction->amount * $user->settings('level_3_commission') / 100;
                        info('Commission amount: ' . $commission_amount);

                        // checking overall netowrking cap


                        // checking overall netowrking cap
                        if ($upliner->remainingCap() >= $commission_amount) {
                            info('Overall Cap is not full. sent commission to ' . $upliner->name);

                            // checking if this user daily cap is not reached
                            if ($upliner->todayRemainingCap() >= $commission_amount) {
                                info('Daily Cap is not full. sent commission to ' . $upliner->name);
                            } else {
                                info('Daily Cap is full. adjusting commission from account: ' . $upliner->name);
                                // adjusting commission
                                $diff = $commission_amount - $upliner->todayRemainingCap();
                                $diffTransaction = Transaction::firstOrCreate([
                                    'user_id' => $upliner->id,
                                    'user_plan_id' => $event->transaction->userPlan->id,
                                    'amount' => $diff,
                                    'status' => 'approved',
                                    'type' => 'balance adjustment',
                                    'sum' => false,
                                    'reference' => 'Networking Daily Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                                ]);
                            }
                        } else {
                            info('Overall Cap is full. adjusting commission from account: ' . $upliner->name);
                            // adjusting commission
                            $diff = $commission_amount - $upliner->remainingCap();
                            $diffTransaction = Transaction::firstOrCreate([
                                'user_id' => $upliner->id,
                                'user_plan_id' => $event->transaction->userPlan->id,
                                'amount' => $diff,
                                'status' => 'approved',
                                'type' => 'balance adjustment',
                                'sum' => false,
                                'reference' => 'Networking Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                            ]);
                        }

                        // adding commission
                        $transaction = Transaction::firstOrCreate([
                            'user_id' => $upliner->id,
                            'user_plan_id' => $event->transaction->userPlan->id,
                            'amount' => $commission_amount,
                            'status' => 'approved',
                            'type' => 'commission',
                            'additional_type' => 'level 3 commission',
                            'sum' => true,
                            'reference' => 'level 3 commission from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                        ]);
                        info('Commission added: ' . $transaction->id);


                        // level 4 commission
                        if ($upliner->upliner) {
                            $upliner = $upliner->upliner;
                            $commission_amount = $event->transaction->amount * $user->settings('level_4_commission') / 100;
                            info('Commission amount: ' . $commission_amount);

                            // checking overall netowrking cap


                            // checking overall netowrking cap
                            if ($upliner->remainingCap() >= $commission_amount) {
                                info('Overall Cap is not full. sent commission to ' . $upliner->name);

                                // checking if this user daily cap is not reached
                                if ($upliner->todayRemainingCap() >= $commission_amount) {
                                    info('Daily Cap is not full. sent commission to ' . $upliner->name);
                                } else {
                                    info('Daily Cap is full. adjusting commission from account: ' . $upliner->name);
                                    // adjusting commission
                                    $diff = $commission_amount - $upliner->todayRemainingCap();
                                    $diffTransaction = Transaction::firstOrCreate([
                                        'user_id' => $upliner->id,
                                        'user_plan_id' => $event->transaction->userPlan->id,
                                        'amount' => $diff,
                                        'status' => 'approved',
                                        'type' => 'balance adjustment',
                                        'sum' => false,
                                        'reference' => 'Networking Daily Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                                    ]);
                                }
                            } else {
                                info('Overall Cap is full. adjusting commission from account: ' . $upliner->name);
                                // adjusting commission
                                $diff = $commission_amount - $upliner->remainingCap();
                                $diffTransaction = Transaction::firstOrCreate([
                                    'user_id' => $upliner->id,
                                    'user_plan_id' => $event->transaction->userPlan->id,
                                    'amount' => $diff,
                                    'status' => 'approved',
                                    'type' => 'balance adjustment',
                                    'sum' => false,
                                    'reference' => 'Networking Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                                ]);
                            }

                            // adding commission
                            $transaction = Transaction::firstOrCreate([
                                'user_id' => $upliner->id,
                                'user_plan_id' => $event->transaction->userPlan->id,
                                'amount' => $commission_amount,
                                'status' => 'approved',
                                'type' => 'commission',
                                'additional_type' => 'level 4 commission',
                                'sum' => true,
                                'reference' => 'level 4 commission from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                            ]);
                            info('Commission added: ' . $transaction->id);


                            // level 5 commission
                            if ($upliner->upliner) {
                                $upliner = $upliner->upliner;
                                $commission_amount = $event->transaction->amount * $user->settings('level_5_commission') / 100;
                                info('Commission amount: ' . $commission_amount);

                                // checking overall netowrking cap


                                // checking overall netowrking cap
                                if ($upliner->remainingCap() >= $commission_amount) {
                                    info('Overall Cap is not full. sent commission to ' . $upliner->name);

                                    // checking if this user daily cap is not reached
                                    if ($upliner->todayRemainingCap() >= $commission_amount) {
                                        info('Daily Cap is not full. sent commission to ' . $upliner->name);
                                    } else {
                                        info('Daily Cap is full. adjusting commission from account: ' . $upliner->name);
                                        // adjusting commission
                                        $diff = $commission_amount - $upliner->todayRemainingCap();
                                        $diffTransaction = Transaction::firstOrCreate([
                                            'user_id' => $upliner->id,
                                            'user_plan_id' => $event->transaction->userPlan->id,
                                            'amount' => $diff,
                                            'status' => 'approved',
                                            'type' => 'balance adjustment',
                                            'sum' => false,
                                            'reference' => 'Networking Daily Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                                        ]);
                                    }
                                } else {
                                    info('Overall Cap is full. adjusting commission from account: ' . $upliner->name);
                                    // adjusting commission
                                    $diff = $commission_amount - $upliner->remainingCap();
                                    $diffTransaction = Transaction::firstOrCreate([
                                        'user_id' => $upliner->id,
                                        'user_plan_id' => $event->transaction->userPlan->id,
                                        'amount' => $diff,
                                        'status' => 'approved',
                                        'type' => 'balance adjustment',
                                        'sum' => false,
                                        'reference' => 'Networking Cap adjustment from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                                    ]);
                                }

                                // adding commission
                                $transaction = Transaction::firstOrCreate([
                                    'user_id' => $upliner->id,
                                    'user_plan_id' => $event->transaction->userPlan->id,
                                    'amount' => $commission_amount,
                                    'status' => 'approved',
                                    'type' => 'commission',
                                    'additional_type' => 'level 5 commission',
                                    'sum' => true,
                                    'reference' => 'level 5 commission from ' . $user->username . ' on ' . $event->transaction->userPlan->plan->name . ' plan activation',
                                ]);
                                info('Commission added: ' . $transaction->id);
                            }
                        }
                    }
                }
            }
        } else {
            info("User Deposit not found for {$user->username} skipping commission delivery");
        }
    }
}
