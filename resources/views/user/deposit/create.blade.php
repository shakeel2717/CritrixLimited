@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h4>Deposit Funds</h4>
                <p>Please send your Number::currency($amount) to the following account</p>
                <form method="POST" action="{{ route('user.deposit.store') }}">
                    @csrf
                    <div class="row">
                        <table class="table table-borderd">
                            <tr>
                                <th>Account Title</th>
                                <th>Account #</th>
                            </tr>
                            <td>XYZ</td>
                            <td>12345</td>
                        </table>
                    </div>
                    <p>After payment successfull, send your payment proof to verify your payment transaction.</p>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="transaction_number">Transaction ID/Reference Number</label>
                            <input type="text" name="transaction_number" id="transaction_number" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="screenshot">Screenshot</label>
                            <input type="file" class="form-control" name="screenshot">
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">Submit Deposit Request</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection