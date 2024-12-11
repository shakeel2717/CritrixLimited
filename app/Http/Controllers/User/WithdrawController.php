<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use App\Http\Requests\StoreWithdrawRequest;
use App\Http\Requests\UpdateWithdrawRequest;
use App\Models\Transaction;
use App\Notifications\SendWithdrawRequestNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.withdraw.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.withdraw.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWithdrawRequest $request)
    {
        // checking sufficient balance
        if (auth()->user()->withdraw_balance() < $request->validated(['amount'])) {
            return redirect()->back()->with('error', 'Insufficient balance.');
        }
        // checking if withdraw is enabled
        if (!auth()->user()->settings('withdraw_active')) {
            return back()->with('error', 'Withdraw is disabled.');
        }

        // checking min withdraw
        if (auth()->user()->settings('min_withdraw') > $request->validated(['amount'])) {
            return back()->with('error', 'Minimum withdraw amount is ' . auth()->user()->settings('min_withdraw'));
        }

        // checking if this user has kyc approved
        if (!auth()->user()->kyc || auth()->user()->kyc->status != 'approved') {
            return back()->with('error', 'KYC is not approved');
        }

        // checking if this is fake account
        if (auth()->user()->fake) {
            return back()->with('error', 'Not Authorized');
            die();
        }

        $withdraw_fees = 0;
        if (auth()->user()->settings('withdraw_fees') > 0) {
            $withdraw_fees = $request->validated('amount') * auth()->user()->settings('withdraw_fees') / 100;
        }

        DB::transaction(function () use ($request, $withdraw_fees) {
            // adding withdraw request
            $withdraw = new Withdraw();
            $withdraw->user_id = auth()->user()->id;
            $withdraw->status = false;
            $withdraw->wallet = $request->validated(['wallet']);
            $withdraw->amount = $request->validated(['amount']) - $withdraw_fees;
            $withdraw->fee = $withdraw_fees;
            $withdraw->save();

            // adding transaction history
            // adding history
            $transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'withdraw_id' => $withdraw->id,
                'amount' => $request->validated(['amount']) - $withdraw_fees,
                'status' => 'pending',
                'type' => 'withdraw',
                'sum' => false,
                'reference' => "Withdraw request for " . Number::currency($request->validated(['amount'])) . " to " . $request->validated(['wallet']),
            ]);

            $transaction->user->notify(new SendWithdrawRequestNotification($transaction));

            if ($withdraw_fees > 0) {
                $transaction = Transaction::create([
                    'user_id' => auth()->user()->id,
                    'withdraw_id' => $withdraw->id,
                    'amount' => $withdraw_fees,
                    'status' => 'pending',
                    'type' => 'withdraw fees',
                    'sum' => false,
                    'reference' => "Withdraw request for " . Number::currency($request->validated(['amount'])) . " to " . $request->validated(['wallet']),
                ]);
            }
        });

        return back()->with('success', 'Withdraw request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWithdrawRequest $request, Withdraw $withdraw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }
}
