@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-0 text-center">Available Balance:
                        {{ Number::currency(auth()->user()->withdraw_balance() ,'MYR' .'ms_MY') }}
                    </h3>
                    <p class="text-center mb-0">This is your available balance, you can withdraw/transfer anytime</p>
                    <h6 class="text-center mt-4">Transfer Fees: {{ 0 }}%</h6>
                    <h6 class="text-center mt-4">Min Transfer: {{ Number::currency(1 ) }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Withdraw Funds</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.transfer.store') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="username" class="form-label">Enter Participant Username</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter Username here" required>
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
                            <button type="submit" class="btn btn-light btn-lg">Transfer Fund Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
