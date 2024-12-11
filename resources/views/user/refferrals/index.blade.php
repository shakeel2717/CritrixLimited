@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                   <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Sr</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Total Investment</th>
                            <th>Joined at</th>
                        </thead>
                        <tbody>
                           @foreach ($refferrals as $refferral)
                               <tr>
                                <td>{{$refferral->id}}</td>
                                <td>{{$refferral->name}}</td>
                                <td>{{$refferral->username}}</td>
                                <td>{{$refferral->email}}</td>
                                <td>{{number_format($refferral->investment())}}</td>
                                <td>{{$refferral->created_at->format('d-M-Y')}}</td>
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
