<?php

namespace App\Http\Controllers;

use App\Events\UserPlanActivated;
use App\Models\Plan;
use App\Models\Transaction;
use App\Notifications\PlanActivatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("user.plan.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plans = Plan::where('status', true)->get();
        return view('user.plan.create', compact('plans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|integer|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);

        // activating user plan
        $user = $request->user();

        if ($user->fake) {
            return back()->with('error', 'Not Authorized');
            die();
        }

        // checking sufficient balance
        if ($user->full_balance() < $plan->price) {
            return redirect()->route('user.dashboard.index')->with('error', 'Insufficient balance.');
        }

        $userPlan = $user->userPlans()->create([
            'plan_id' => $plan->id,
            'status' => true,
        ]);

        // adding history
        $transaction = Transaction::firstOrCreate([
            'user_id' => $user->id,
            'user_plan_id' => $userPlan->id,
            'amount' => $plan->price,
            'status' => 'approved',
            'type' => 'plan activation',
            'sum' => false,
            'reference' => $plan->name . " Plan Activation For: " . Number::currency($plan->price),
        ]);

        // if user is not pin
        if ($user->type != 'pin') {
            UserPlanActivated::dispatch($transaction);
        }

        $transaction->user->notify(new PlanActivatedNotification($transaction));

        return redirect()->route('user.dashboard.index')->with('success', 'Plan activated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return view('user.plan.show', compact('plan'));
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
