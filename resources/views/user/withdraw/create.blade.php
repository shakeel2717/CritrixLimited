@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-0 text-center">Available Balance: {{ Number::currency(auth()->user()->withdraw_balance(),'MYR' ,'ms_My') }}
                    </h3>
                    <p class="text-center mb-0">This is your available balance, you can withdraw anytime</p>
                    <h6 class="text-center mt-4">Withdraw Fees: {{ auth()->user()->settings('withdraw_fees') }}%</h6>
                    <h6 class="text-center mt-4">Min Withdraw:  {{ Number::currency(auth()->user()->settings('min_withdraw') ,'MYR' ,'ms_MY') }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Withdraw Funds</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.withdraw.store') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="currency" class="form-label">Select Currency</label>
                            <div class="form-group">
                                <select name="currency" id="currency" class="form-select">
                                    <option value="USDT.TRC20">USDT (TRC20)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="wallet" class="form-label">Your USDT(TRC20) Wallet Address</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="wallet" name="wallet"
                                    placeholder="Enter wallet address" required>
                                <small class="form-text text-light">Only USDT(TRC20) addresses are accepted, otherwise you
                                    may lose your funds.</small>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="amount" class="form-label">Enter Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="Enter amount" required min="1" step="any">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-light btn-lg">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
