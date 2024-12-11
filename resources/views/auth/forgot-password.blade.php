@extends('layouts.auth')
@section('form')
    <div class="card-body">
        <div class="border p-4 rounded">
            <div class="text-center">
                <h3 class="">Recover Your Password?</h3>
                <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>
            <div class="form-body">
                <form class="row g-3" action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id="inputEmailAddress" placeholder="Email Address">
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-light"><i
                                    class="bx bxs-lock-open"></i>{{ __('Email Password Reset Link') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
