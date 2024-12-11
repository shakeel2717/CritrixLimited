@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-0 text-center">Available Balance: {{ Number::currency(auth()->user()->full_balance()) }}
                    </h3>
                    <p class="text-center mb-0">This is your overall available balance, you can use it to invest</p>
                </div>
            </div>
        </div>
        @foreach ($plans as $plan)
            <div class="col-md-3">
                <div class="card shadow-sm py-5">
                    <div class="card-header text-center">
                        <h4 class="text-uppercase">{{ $plan->name }}</h4>
                        <div class="rounded-3 bg-light text-white p-2">
                            <h1 class="display-4 fw-bold mb-0">{{ Number::abbreviate($plan->price,2) }}</h1>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0 ps-3 list-unstyled d-flex flex-column gap-3">
                            <li>Daily Return: {{ $plan->profit }}%</li>
                            <li>Total Return: {{ $plan->total_return }}x</li>
                            <li>Daily Network Cap: {{ Number::currency($plan->earning_cap ,'MYR' ,'ms_MY') }}</li>
                            <li>Instant Deposit / Withdraw</li>
                            <li>24/7 Customer Support</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('user.plans.show', $plan) }}" class="btn btn-lg btn-light w-100">Get Started</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
