@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Deposit Funds</h4>
                    </div>
                    <div class="card-body text-center">
                        <h5>Send <strong>{{ Number::currency($payment['amount'] ,'MYR' ,'ms_MY') }} USDT</strong> to the address below</h5>
                        <p class="mt-3"><strong>Wallet Address:</strong></p>
                        <p class="bg-light p-2 rounded">{{ $payment['address'] }}</p>

                        <!-- QR Code -->
                        <img src="{{ $payment['qrcode_url'] }}" alt="QR Code" class="img-fluid" style="max-width: 250px;">

                        <!-- Copy Address Button -->
                        <div class="mt-4">
                            <button class="btn btn-primary" onclick="copyToClipboard('{{ $payment['address'] }}')">Copy
                                Address</button>
                        </div>

                        <!-- User Instructions -->
                        <div class="mt-4 text-start border border-secondary rounded p-4">
                            <h6>Instructions:</h6>
                            <ul class="list-unstyled">
                                <li>1. Scan the QR code with your wallet app.</li>
                                <li>2. Ensure the correct amount of <strong>{{ Number::currency($payment['amount'],'MYR' ,'ms_MY') }}
                                        USDT</strong> is entered.</li>
                                <li>3. Confirm the transaction and wait for confirmation.</li>
                                <li>4. Confirm the transaction and wait for the confirmation.</li>
                                <li>5. <strong class="text-success">Note:</strong> Once the transaction is confirmed, the
                                    funds will be
                                    automatically added to your account.</li>
                            </ul>
                        </div>

                        <!-- Back Button -->
                        <a href="{{ route('user.dashboard.index') }}" class="btn btn-secondary mt-4">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to copy address to clipboard
        function copyToClipboard(address) {
            var el = document.createElement('textarea');
            el.value = address;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            alert('Wallet address copied to clipboard!');
        }
    </script>
@endsection
