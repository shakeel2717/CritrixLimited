@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @foreach (auth()->user()->transactions()->latest()->get() as $transaction)
                            <tr>
                                <td>{{$transaction->user->username}}</td>
                                <td><span class="badge bg-primary">{{strtoupper($transaction->type)}}</span></td>
                                <td>{{Number::currency($transaction->amount ,'MYR' ,'ms_My')}}</td>
                                <td>{{$transaction->reference}}</td>
                                <td><span class="badge bg-primary">{{strtoupper($transaction->status)}}</span></td>
                                <td>{{$transaction->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection