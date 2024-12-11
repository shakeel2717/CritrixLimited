<?php

namespace Database\Seeders;

use App\Models\NetworkCommission;
use App\Models\Plan;
use App\Models\SiteSetting;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'role' => 'admin',
            'password' => bcrypt('asdfasdf'),
        ]);


        $user = User::create([
            'name' => 'Shakeel Ahmad',
            'username' => 'shakeel2717',
            'email' => 'shakeel2717@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('asdfasdf'),
        ]);

        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'amount' => 10000,
            'status' => 'approved',
            'type' => 'deposit',
            'sum' => true,
            'reference' => "CoinPayments Deposit",
        ]);

        $user = User::create([
            'name' => 'Gojra 1',
            'username' => 'gojra1',
            'email' => 'gojra1@gmail.com',
            'email_verified_at' => now(),
            'referral_id' => $user->id,
            'password' => bcrypt('asdfasdf'),
        ]);

        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'amount' => 31000,
            'status' => 'approved',
            'type' => 'deposit',
            'sum' => true,
            'reference' => "CoinPayments Deposit",
        ]);

        $user = User::create([
            'name' => 'Gojra 2',
            'username' => 'gojra2',
            'email' => 'gojra2@gmail.com',
            'email_verified_at' => now(),
            'referral_id' => $user->id,
            'password' => bcrypt('asdfasdf'),
        ]);

        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'amount' => 1000,
            'status' => 'approved',
            'type' => 'deposit',
            'sum' => true,
            'reference' => "CoinPayments Deposit",
        ]);

        $user = User::create([
            'name' => 'Gojra 3',
            'username' => 'gojra3',
            'email' => 'gojra3@gmail.com',
            'email_verified_at' => now(),
            'referral_id' => $user->id,
            'password' => bcrypt('asdfasdf'),
        ]);

        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'amount' => 1000,
            'status' => 'approved',
            'type' => 'deposit',
            'sum' => true,
            'reference' => "CoinPayments Deposit",
        ]);

        $user = User::create([
            'name' => 'Gojra 4',
            'username' => 'gojra4',
            'email' => 'gojra4@gmail.com',
            'email_verified_at' => now(),
            'referral_id' => $user->id,
            'password' => bcrypt('asdfasdf'),
        ]);

        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'amount' => 1000,
            'status' => 'approved',
            'type' => 'deposit',
            'sum' => true,
            'reference' => "CoinPayments Deposit",
        ]);

        $user = User::create([
            'name' => 'Gojra 5',
            'username' => 'gojra5',
            'email' => 'gojra5@gmail.com',
            'email_verified_at' => now(),
            'referral_id' => $user->id,
            'password' => bcrypt('asdfasdf'),
        ]);

        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'amount' => 1000,
            'status' => 'approved',
            'type' => 'deposit',
            'sum' => true,
            'reference' => "CoinPayments Deposit",
        ]);

        $user = User::create([
            'name' => 'Gojra 6',
            'username' => 'gojra6',
            'email' => 'gojra6@gmail.com',
            'email_verified_at' => now(),
            'referral_id' => $user->id,
            'password' => bcrypt('asdfasdf'),
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'Interns',
            'price' => 250,
            'profit' => 4.16,
            'Total days'=>120,
            'total_return' => 500,
            'earning_cap' => 25,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'Elite',
            'price' => 600,
            'profit' => 10.5,
            'Total days' => 120,
            'total_return' => 1260,
            'earning_cap' => 50,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'Master',
            'price' =>1000,
            'profit' => 18.37,
            'total days' => 120,
            'total_return' => 2150,
            'earning_cap' => 100,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'Top Tier',
            'price' =>1500,
            'profit' => 28.69,
            'Total days' => 115,
            'total_return' => 3300,
            'earning_cap' => 250,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'Premium',
            'price' =>2500,
            'profit' => 51.13,
            'total days' => 110,
            'total_return' => 5625,
            'earning_cap' => 500,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'Executive',
            'price' => 3500,
            'profit' => 76.15,
            'total days' => 108,
            'total_return' => 8225,
            'earning_cap' => 1000,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'high Roller',
            'price' => 5000,
            'profit' => 118,
            'total days' => 105,
            'total_return' =>12400,
            'earning_cap' => 2500,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'Superior',
            'price' => 10000,
            'profit' =>252.42,
            'total days' =>103,
            'total_return' => 26000,
            'earning_cap' => 5000,
        ]);
        $plan = Plan::firstOrCreate([
            'name' => 'high Roller',
            'price' => 15000,
            'profit' => 405,
            'total days' => 100,
            'total_return' => 40500,
            'earning_cap' => 5000,
        ]);
        $plan = Plan::firstOrCreate([
            'name' => 'Superior',
            'price' => 25000,
            'profit' => 833.33,
            'total days' => 90,
            'total_return' => 75000,
            'earning_cap' => 5000,
        ]);

        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'amount' => 1000,
            'status' => 'approved',
            'type' => 'deposit',
            'sum' => true,
            'reference' => "CoinPayments Deposit",
        ]);
        $setting = SiteSetting::create([
            'key' => 'deposit_active',
            'value' => true,
        ]);

        $setting = SiteSetting::create([
            'key' => 'withdraw_active',
            'value' => true,
        ]);

        $setting = SiteSetting::create([
            'key' => 'min_withdraw',
            'value' => 20,
        ]);

        $setting = SiteSetting::create([
            'key' => 'withdraw_fees',
            'value' => 5,
        ]);


        $setting = SiteSetting::create([
            'key' => 'level_1_commission',
            'value' => 10,
        ]);

        $setting = SiteSetting::create([
            'key' => 'level_2_commission',
            'value' => 5,
        ]);

        $setting = SiteSetting::create([
            'key' => 'level_3_commission',
            'value' => 2,
        ]);

        $setting = SiteSetting::create([
            'key' => 'level_4_commission',
            'value' => 2,
        ]);

        $setting = SiteSetting::create([
            'key' => 'level_5_commission',
            'value' => 1,
        ]);

        $setting = SiteSetting::create([
            'key' => 'kyc_approval_bonus',
            'value' => 10,
        ]);


        $setting = SiteSetting::create([
            'key' => 'kyc_approval_bonus_for_upliner',
            'value' => 5,
        ]);


        $setting = SiteSetting::create([
            'key' => 'stop_roi_for_all_accounts',
            'value' => false,
        ]);

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Trust';
        $networkCommission->business = 1000;
        $networkCommission->reward = 100;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Beacon';
        $networkCommission->business = 3000;
        $networkCommission->reward = 300;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Haven';
        $networkCommission->business = 10000;
        $networkCommission->reward = 1000;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Summit';
        $networkCommission->business = 15000;
        $networkCommission->reward = 1500;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Noble';
        $networkCommission->business = 25000;
        $networkCommission->reward = 2500;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Apex';
        $networkCommission->business = 80000;
        $networkCommission->reward = 8000;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Prime';
        $networkCommission->business = 150000;
        $networkCommission->reward = 15000;
        $networkCommission->save();
    }
}
