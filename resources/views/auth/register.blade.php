@extends('layouts.auth')
@section('form')
<div class="card-body">
    <div class="border p-4 rounded">
        <div class="text-center">
            <h3 class="">Create free Account</h3>
            <p>Already have an account yet? <a href="{{ route('login') }}">Sign in
                    here</a>
            </p>
        </div>
        @if ($username)
        <div class="card">
            <div class="card-body border rounded">
                <div class="">
                    <div class="text-center">
                        <h6 class="mb-0">Your Sponsor: {{ $username }}</h6>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="form-body">
            <form class="row g-3" action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="referral" value="{{ $username }}">
                <div class="col-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                </div>
                <div class="col-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username"
                        placeholder="Enter Username">
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email"
                        placeholder="Email Address">
                </div>
                <div class="col-6">
                    <label for="country" class="form-label">Select Country</label>
                    <select name="country" id="country" class="form-select">
                        @include('inc.countries')
                    </select>
                </div>
                <div class="col-6">
                    <label for="phone" class="form-label">Mobile Number</label>
                    <input type="text" name="phone" class="form-control" id="phone"
                        placeholder="Enter Mobile Number">
                    <small>Mobile number includes country code</small>
                </div>
                <div class="col-12">
                    <label for="whatsapp" class="form-label">WhatsApp Number</label>
                    <input type="tel" name="whatsapp" class="form-control" id="whatsapp"
                        placeholder="Enter WhatsApp Number"  required
                        aria-describedby="whatsappHelp">
                    <small id="whatsappHelp" class="form-text text-muted">
                        Include the country code.
                    </small>
                    <div class="invalid-feedback">
                        Please enter a valid WhatsApp number.
                    </div>
                </div>

                <div class="col-12">
                    <label for="password" class="form-label">Enter
                        Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" name="password" class="form-control border-end-0" id="password"
                            placeholder="Enter Password">
                        <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                    </div>
                </div>
                <div class="col-12">
                    <label for="password_confirmation" class="form-label">Confirm
                        Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" name="password_confirmation" class="form-control border-end-0"
                            id="password_confirmation" placeholder="Enter Password">
                        <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked required>
                        <label class="form-check-label" for="flexSwitchCheckChecked">I agree to the terms and
                            conditions</label>
                    </div>
                </div>
                <div class="col-md-6 text-end"> <a href="{{ route('password.request') }}">Forgot Password ?</a>
                </div>
                <div class="col-12">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-light"><i class="bx bxs-lock-open"></i>Create
                            Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection