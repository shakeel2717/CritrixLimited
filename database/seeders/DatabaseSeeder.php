<?php

namespace Database\Seeders;

use App\Models\NetworkCommission;
use App\Models\PaymentMethod;
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

        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'amount' => 100000,
            'status' => 'approved',
            'type' => 'deposit',
            'sum' => true,
            'reference' => "CoinPayments Deposit",
        ]);


        $user = User::create([
            'name' => 'Shakeel Ahmad',
            'username' => 'shakeel2717',
            'email' => 'shakeel2717@gmail.com',
            'email_verified_at' => now(),
            'whatsapp' => '923037702717',
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

        // $user = User::create([
        //     'name' => 'Gojra 1',
        //     'username' => 'gojra1',
        //     'email' => 'gojra1@gmail.com',
        //     'email_verified_at' => now(),
        //     'referral_id' => $user->id,
        //     'whatsapp' => '923037702711',
        //     'password' => bcrypt('asdfasdf'),
        // ]);

        // $transaction = Transaction::firstOrCreate([
        //     'user_id' => $user->id,
        //     'amount' => 31000,
        //     'status' => 'approved',
        //     'type' => 'deposit',
        //     'sum' => true,
        //     'reference' => "CoinPayments Deposit",
        // ]);

        // $user = User::create([
        //     'name' => 'Gojra 2',
        //     'username' => 'gojra2',
        //     'email' => 'gojra2@gmail.com',
        //     'email_verified_at' => now(),
        //     'referral_id' => $user->id,
        //     'whatsapp' => '923037702712',
        //     'password' => bcrypt('asdfasdf'),
        // ]);

        // $transaction = Transaction::firstOrCreate([
        //     'user_id' => $user->id,
        //     'amount' => 1000,
        //     'status' => 'approved',
        //     'type' => 'deposit',
        //     'sum' => true,
        //     'reference' => "CoinPayments Deposit",
        // ]);

        // $user = User::create([
        //     'name' => 'Gojra 3',
        //     'username' => 'gojra3',
        //     'email' => 'gojra3@gmail.com',
        //     'email_verified_at' => now(),
        //     'referral_id' => $user->id,
        //     'whatsapp' => '923037702713',
        //     'password' => bcrypt('asdfasdf'),
        // ]);

        // $transaction = Transaction::firstOrCreate([
        //     'user_id' => $user->id,
        //     'amount' => 1000,
        //     'status' => 'approved',
        //     'type' => 'deposit',
        //     'sum' => true,
        //     'reference' => "CoinPayments Deposit",
        // ]);

        // $user = User::create([
        //     'name' => 'Gojra 4',
        //     'username' => 'gojra4',
        //     'email' => 'gojra4@gmail.com',
        //     'email_verified_at' => now(),
        //     'referral_id' => $user->id,
        //     'whatsapp' => '923037702714',
        //     'password' => bcrypt('asdfasdf'),
        // ]);

        // $transaction = Transaction::firstOrCreate([
        //     'user_id' => $user->id,
        //     'amount' => 1000,
        //     'status' => 'approved',
        //     'type' => 'deposit',
        //     'sum' => true,
        //     'reference' => "CoinPayments Deposit",
        // ]);

        // $user = User::create([
        //     'name' => 'Gojra 5',
        //     'username' => 'gojra5',
        //     'email' => 'gojra5@gmail.com',
        //     'email_verified_at' => now(),
        //     'referral_id' => $user->id,
        //     'whatsapp' => '923037702715',
        //     'password' => bcrypt('asdfasdf'),
        // ]);

        // $transaction = Transaction::firstOrCreate([
        //     'user_id' => $user->id,
        //     'amount' => 1000,
        //     'status' => 'approved',
        //     'type' => 'deposit',
        //     'sum' => true,
        //     'reference' => "CoinPayments Deposit",
        // ]);

        // $user = User::create([
        //     'name' => 'Gojra 6',
        //     'username' => 'gojra6',
        //     'email' => 'gojra6@gmail.com',
        //     'email_verified_at' => now(),
        //     'referral_id' => $user->id,
        //     'whatsapp' => '923037702716',
        //     'password' => bcrypt('asdfasdf'),
        // ]);

        $plan = Plan::firstOrCreate([
            'name' => 'BASIC',
            'price' => 250,
            'profit' => 4,
            'Total days'=>125,
            'total_return' => 500,
            'earning_cap' => 25,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'STARTER',
            'price' => 600,
            'profit' => 10.08,
            'Total days' => 125,
            'total_return' => 1260,
            'earning_cap' => 50,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'ADVANCE',
            'price' =>1000,
            'profit' => 17.2,
            'total days' => 125,
            'total_return' => 2150,
            'earning_cap' => 100,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'TRADER',
            'price' =>1500,
            'profit' => 26.4,
            'Total days' => 125,
            'total_return' => 3300,
            'earning_cap' => 250,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'MASTER',
            'price' =>2500,
            'profit' => 45,
            'total days' => 125,
            'total_return' => 5625,
            'earning_cap' => 500,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'ELITE',
            'price' => 3500,
            'profit' => 65.8,
            'total days' => 125,
            'total_return' => 8225,
            'earning_cap' => 1000,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'TYCOON',
            'price' => 5000,
            'profit' => 99.20,
            'total days' => 125,
            'total_return' =>12400,
            'earning_cap' => 2500,
        ]);

        $plan = Plan::firstOrCreate([
            'name' => 'Top Tier',
            'price' => 10000,
            'profit' =>208,
            'total days' =>125,
            'total_return' => 26000,
            'earning_cap' => 5000,
        ]);
        $plan = Plan::firstOrCreate([
            'name' => 'PREMIUM',
            'price' => 15000,
            'profit' => 324,
            'total days' => 125,
            'total_return' => 40500,
            'earning_cap' => 5000,
        ]);
        $plan = Plan::firstOrCreate([
            'name' => 'Superior',
            'price' => 25000,
            'profit' => 600,
            'total days' => 125,
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
        $networkCommission->name = 'Associate';
        $networkCommission->business = 1000;
        $networkCommission->reward = 100;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Senior';
        $networkCommission->business = 3000;
        $networkCommission->reward = 300;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Manager';
        $networkCommission->business = 10000;
        $networkCommission->reward = 1000;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Director';
        $networkCommission->business = 15000;
        $networkCommission->reward = 1500;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Senior Director';
        $networkCommission->business = 25000;
        $networkCommission->reward = 2500;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'President';
        $networkCommission->business = 80000;
        $networkCommission->reward = 8000;
        $networkCommission->save();

        $networkCommission = new NetworkCommission();
        $networkCommission->name = 'Vice President';
        $networkCommission->business = 150000;
        $networkCommission->reward = 15000;
        $networkCommission->save();

        // adding payment method
        $payment_method = new PaymentMethod();
        $payment_method->name = 'InstaPay';
        $payment_method->account_title = 'Abid Hameed';
        $payment_method->account_number = '+60142885419';
        $payment_method->save();

        // adding payment method
        $payment_method = new PaymentMethod();
        $payment_method->name = 'USDT TRC20';
        $payment_method->account_title = 'Tether';
        $payment_method->account_number = 'TNuVMYPRkUt9rzwMp1uHm2p9hZNzpZ4u9N';
        $payment_method->save();
    }
}
