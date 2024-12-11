<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use App\Services\CoinPaymentsService;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    protected $coinPayments;

    public function __construct(CoinPaymentsService $coinPaymentsService)
    {
        $this->coinPayments = $coinPaymentsService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.deposit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.deposit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            $transaction = $this->coinPayments->createTransaction($request->amount, auth()->user()->email);
            info('Transaction created in Controller: ' . json_encode($transaction));

            if (isset($transaction['amount'])) {
                $transaction['user_id'] = auth()->user()->id;
                // Store transaction details in database
                $payment = Payment::create($transaction);

                // Redirect to CoinPayments checkout page
                return to_route('user.checkout.show', ['checkout' => $payment->txn_id]);
            } else {
                return back()->withErrors("Transaction creation failed");
            }
        } catch (\Exception $e) {
            info('Transaction creation failed in Controller: ' . $e->getMessage());
            return back()->withErrors($e->getMessage());
        }
    }

    public function webhook(Request $request)
    {
        info('Webhook received: ' . json_encode($request->all()));
        try {
            $data = $this->coinPayments->verifyIPN($request->all());

            // Log or update database with transaction details
            info('CoinPayments IPN Verified: ', $data);

            // adding balance to user account

            $payment = Payment::where('txn_id', $data['txn_id'])->firstOrFail();
            if ($data['status'] >= 1) {


                $transaction = Transaction::firstOrCreate([
                    'user_id' => $payment->user_id,
                    'payment_id' => $payment->id,
                    'amount' => $data['amount1'],
                    'status' => 'approved',
                    'type' => 'deposit',
                    'sum' => true,
                    'reference' => "USDT Gateway " . $payment->txn_id . " Deposit",
                ]);

                // check if recently created
                if ($transaction->wasRecentlyCreated) {
                    info("New transaction created");
                    $payment->status = "completed";
                    $payment->save();

                    info("Payment updated");
                } else {
                    info("Transaction already exists");
                }

                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'IPN received successfully'
                ]);
            } else {
                info('CoinPayments Status is Still pending ' . $data['status']);
                $payment->status = "pending";
                $payment->save();
            }
        } catch (\Exception $e) {
            info('CoinPayments IPN verification failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
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
