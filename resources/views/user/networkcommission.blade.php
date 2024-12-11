@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                   <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Name</th>
                            <th>Network Bonus</th>
                            <th>Reward</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach ($networks as $network)
                                <tr>
                                    <td>{{$network->name}}</td>
                                    <td>${{number_format($network->business,2)}}</td>
                                    <td>${{number_format($network->reward,2)}}</td>
                                    <td><span class=" fs-3 {{ auth()->user()->netowrkReward($network->reward) ? 'text-white' : 'text-secondary' }}"><i class='bx bx-check-circle'></i></span></td>
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
