@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Deposit Funds</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.deposit.store') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="amount" class="form-label">Enter Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">Rm</span>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter deposit amount" required min="1" step="any">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection