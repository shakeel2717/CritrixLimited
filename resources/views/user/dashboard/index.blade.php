@extends('layouts.app')
@section('content')

{{-- @if (auth()->user()->role == 'admin')
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="{{ route('user.command.store') }}" method="POST">
@csrf
<div class="input-group mb-3">
    <input type="text" class="form-control" name="command" placeholder="Enter Command">
    <button class="btn btn-primary" type="submit">Run Command</button>
</div>
</form>
</div>
</div>
@session('output')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="alert bg-light">
            {{ session('output') }}
        </div>
    </div>
</div>
@endsession
@endif --}}
<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
    <div class="col">
        @include('inc.info-card', [
        'title' => 'Available Balance',
        'value' => auth()->user()->balance(),
        ])
    </div>
    <div class="col">
        @include('inc.info-card', [
        'title' => 'Total Deposit',
        'value' => auth()->user()->transactions()->where('type', 'deposit')->sum('amount'),
        ])
    </div>
    <div class="col-lg-12">
        @include('inc.info-card', [
        'title' => 'Total Withdrawals',
        'value' => auth()->user()->transactions()->where('type', 'withdraw')->sum('amount'),
        ])
    </div>
    <div class="col-lg-12">
        @include('inc.info-card', [
        'title' => 'Total ROI Profits',
        'value' => auth()->user()->daily_profits()->sum('amount'),
        ])
    </div>
    <div class="col-lg-12">
        @include('inc.info-card', [
        'title' => 'Pending Withdrawals',
        'value' => auth()->user()->transactions()->where('type', 'withdraw')->where('status', 'pending')->sum('amount'),
        ])
    </div>
    <div class="col">
        @include('inc.info-card', [
        'title' => 'Total Commissions',
        'value' => auth()->user()->totalCommission(),
        ])
    </div>
   
    <div class="col">
        @include('inc.info-card', [
        'title' => 'Total Investment',
        'value' => auth()->user()->investment(),
        ])
    </div>
    <div class="col">
        @include('inc.info-card', [
        'title' => 'Total Direct Commission',
        'value' => auth()->user()->transactions()->where('type', 'commission')->where('additional_type','level 1 commission')->sum('amount'),
        ])
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-1">Recent Transactions</h5>
                        <p class="mb-0 font-13"><i class='bx bxs-calendar'></i>last 5 recent transactions</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Reference</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (auth()->user()->transactions()->latest()->limit(5)->get() as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="text-uppercase fw-bold text-light">
                                    {{ $transaction->type }}
                                </span>
                            </td>
                            <td class="fw-bold">
                                {{ $transaction->sum ? '+' : '-' }}{{ Number::currency($transaction->amount) ,'MYR','ms_MY' }}
                            </td>
                            <td>{{ $transaction->reference }}</td>
                            <td>{{ $transaction->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card radius-10 w-100 overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">Overall Cap</h5>
                    </div>
                </div>
                <div class="mt-5" id="chart20" data-cap-invest="1000"
                    data-cap-total="{{ auth()->user()->networkingCap() }}"
                    data-cap-recieved="{{ auth()->user()->alreadyReceivedCap() }}"></div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <div class="d-flex align-items-center justify-content-between text-center">
                    <div>
                        <h6 class="mb-1 font-weight-bold">
                            {{ Number::currency(auth()->user()->investment() ,'MYR' ,'ms_MY') }}
                        </h6>
                        <p class="mb-0">Investment</p>
                    </div>
                    <div class="mb-1">
                        <h6 class="mb-1 font-weight-bold">{{ Number::currency(auth()->user()->networkingCap() ,'MYR' ,'ms_MY') }}</h6>
                        <p class="mb-0">Total Cap</p>
                    </div>
                </div>
                <hr>
                <div class="d-flex align-items-center justify-content-between text-center">
                    <div>
                        <h6 class="mb-1 font-weight-bold">{{ Number::currency(auth()->user()->alreadyReceivedCap() ,'MYR','ms_MY') }}
                        </h6>
                        <p class="mb-0">Total Earned</p>
                    </div>
                    <div>
                        <h6 class="mb-1 font-weight-bold">{{ Number::currency(auth()->user()->remainingCap() ,'MYR' ,'ms_MY') }}</h6>
                        <p class="mb-0">Remaining Cap</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center gap-3 justify-content-center">
                    <div class="icon-area border-end">
                        <i class='bx bx-trophy fs-1 px-4'></i>
                    </div>
                    <div class="offer-detail">
                        <!-- Attractive Heading -->
                        <h2 class="card-title mb-3">Invite Your Friends!</h2>

                        <!-- Short Description -->
                        <p class="card-text">Share your referral link with friends and earn rewards. They benefit,
                            you benefit. It's a win-win!</p>

                        <!-- Referral Link Section -->
                        <div class="input-group mb-3">
                            <input id="referral-link" type="text" class="form-control"
                                value="{{ route('register', ['username' => auth()->user()->username]) }}" readonly>
                            <button class="btn btn-primary" type="button" id="copy-btn" onclick="copyReferralLink()">
                                <!-- Boxicon Icon -->
                                <i class='bx bx-copy-alt'></i> Copy
                            </button>
                        </div>

                        <!-- Success Message -->
                        <small id="copy-success" class="text-success" style="display:none;">Referral link
                            copied!</small>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto mb-3"><i
                                            class='bx bxs-group'></i>
                                    </div>
                                    <h4 class="my-1">{{ auth()->user()->downline()->count() }}</h4>
                                    <p class="mb-0">Direct Referrals</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto mb-3"><i
                                            class='bx bxs-group'></i>
                                    </div>
                                    <h4 class="my-1">{{ auth()->user()->allDownline(false)->count() }}</h4>
                                    <p class="mb-0">All Downline Referrals</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto mb-3"><i
                                            class='bx bxs-group'></i>
                                    </div>
                                    <h4 class="my-1">{{ auth()->user()->allDownline(true)->count() }}</h4>
                                    <p class="mb-0">All Active Referrals</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="widgets-icons rounded-circle mx-auto mb-3"><i
                                            class='bx bxs-group'></i>
                                    </div>
                                    <h4 class="my-1">{{ Number::currency(auth()->user()->totalSalesOfDownline() ,'MYR' ,'ms_MY') }}</h4>
                                    <p class="mb-0">Total Sales</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-1">Latest Deposits on {{ config('app.name') }}</h5>
                        <p class="mb-0 font-13"><i class='bx bxs-calendar'></i>last 10 recent transactions</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Transaction::where('type', 'deposit')->latest()->limit(10)->get() as $deposit)
                        <tr>
                            <td>{{ str()->mask($deposit->user->username, '*', 3, 5) }}</td>
                            <td>
                                <span
                                    class="text-uppercase fw-bold text-light">
                                    {{ $deposit->type }}
                                </span>
                            </td>
                            <td class="fw-bold">
                                {{ $deposit->sum ? '+' : '-' }}{{ Number::currency($deposit->amount,'MYR','ms_MY') }}
                            </td>
                            <td>{{ $deposit->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-1">Latest Withdrawals on {{ config('app.name') }}</h5>
                        <p class="mb-0 font-13"><i class='bx bxs-calendar'></i>last 10 recent transactions</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Transaction::where('type', 'withdraw')->latest()->limit(10)->get() as $deposit)
                        <tr>
                            <td>{{ str()->mask($deposit->user->username, '*', 3, 5) }}</td>
                            <td>
                                <span
                                    class="text-uppercase fw-bold text-light">
                                    {{ $deposit->type }}
                                </span>
                            </td>
                            <td class="fw-bold">
                                {{ $deposit->sum ? '+' : '-' }}{{ Number::currency($deposit->amount ,'MYR' ,'ms_MY') }}
                            </td>
                            <td>{{ $deposit->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    function copyReferralLink() {
        var referralLink = document.getElementById("referral-link");
        referralLink.select();
        referralLink.setSelectionRange(0, 99999); // For mobile devices

        document.execCommand("copy");

        // Show success message
        var successMessage = document.getElementById("copy-success");
        successMessage.style.display = "inline";

        // Hide the success message after a few seconds
        setTimeout(function() {
            successMessage.style.display = "none";
        }, 2000);
    }
</script>
@endsection