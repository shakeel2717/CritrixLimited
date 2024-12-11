@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <livewire:user.all-transaction type="withdraw" />
                </div>
            </div>
        </div>
    </div>
@endsection
