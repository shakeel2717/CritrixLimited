@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm py-5">
                <div class="card-header text-center">
                    <h4 class="">{{ $plan->name }}</h4>
                    <div class="rounded-3 bg-light text-white p-2">
                        <h1 class="display-1 fw-bold mb-0">${{ Number::abbreviate($plan->price) }}</h1>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="text-center mb-4">Are you sure you want to activate {{ $plan->name }} plan for ${{ Number::currency($plan->price ,'MYR' ,'ms_MY') }}?</p>
                    <form action="{{ route('user.plans.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-light">Confirm Activation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
