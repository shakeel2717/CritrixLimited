@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4 class="mb-0">Deposit: {{ Number::currency($amount, 'MYR', 'ms_MY') }}</h4>
                </div>
                <div class="card-body">
                    <p>Please send {{ Number::currency($amount, 'MYR', 'ms_MY') }} to the following account</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Payment Method</th>
                                    <th>Account Title</th>
                                    <th>Account Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <tr>
                                        <td>{{ $paymentMethod->name }}</td>
                                        <td>{{ $paymentMethod->account_title }}</td>
                                        <td>{{ $paymentMethod->account_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">DuitNow QR Code</h5>
                            <img src="{{ asset('duitnow.jpg') }}" alt="DuitNow" width="200">
                        </div>
                    </div>
                    <p>After sending the payment, please upload the screenshot below and Transaction ID</p>
                    <form method="POST" action="{{ route('user.tid.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4">
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <div class="form-group">
                                <label for="tid" class="form-label">Reference Number/ Transaction ID</label>
                                <input type="number" class="form-control" id="tid" name="tid"
                                    placeholder="Enter reference number" required min="1" step="any">
                            </div>
                            <div class="form-group">
                                <label for="tid" class="form-label">Screenshot</label>
                                <input type="file" class="form-control" id="screenshot" name="screenshot"
                                    placeholder="Enter reference number" required min="1" step="any">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
