<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Notifications\SendTransferFundNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.transfer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'exists:users,username'],
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        // checking sufficient balance
        if (auth()->user()->withdraw_balance() < $validated['amount']) {
            return redirect()->back()->with('error', 'Insufficient balance.');
        }

        
        
        $user = User::where('username', $validated['username'])->firstOrFail();

        // checking if both username is same
        if ($user->id == auth()->user()->id) {
            return redirect()->back()->with('error', 'You cannot transfer to your own account.');
        }

        DB::transaction(function () use ($user, $validated) {

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'status' => 'approved',
                'type' => 'transfer',
                'payment_status' => false,
                'sum' => true,
                'reference' => auth()->user()->username . ' transferred ' . $validated['amount'] . ' to ' . $user->username,
            ]);
            
            
            $transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'amount' => $validated['amount'],
                'status' => 'approved',
                'type' => 'transfer',
                'sum' => false,
                'payment_status' => false,
                'reference' => auth()->user()->username . ' transferred ' . $validated['amount'] . ' to ' . $user->username,
            ]);

            $user->notify(new SendTransferFundNotification($transaction, $user, auth()->user()));
        });

        return back()->with('success', 'Transfer successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
