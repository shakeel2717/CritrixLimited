@extends('layouts.auth')
@section('form')
<div class="card-body">
    <div class="border p-4 rounded">
        <div class="text-center">
            <h3 class="">Sign in</h3>
            <p>Don't have an account yet? <a href="{{ route('register') }}">Sign up
                    here</a>
            </p>
        </div>
        <div class="form-body">
            <form class="row g-3" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="col-12">
                    <label for="login" class="form-label">WhatsApp/Username/Email</label>
                    <input type="text" name="login" class="form-control" id="login"
                        placeholder="Enter WhatsApp/Username/Email"  required
                        aria-describedby="whatsappHelp" value="60">
                    <small id="whatsappHelp" class="form-text text-light">
                        Whatsapp format : 6032022XXXX
                    </small>
                    <div class="invalid-feedback">
                        Please enter a valid WhatsApp number.
                    </div>
                </div>

                <div class="col-12">
                    <label for="inputChoosePassword" class="form-label">Enter
                        Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" name="password" class="form-control border-end-0"
                            id="inputChoosePassword" placeholder="Enter Password"> <a
                            href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                    </div>
                </div>
                <div class="col-md-6 text-end"> <a href="{{ route('password.request') }}">Forgot Password ?</a>
                </div>
                <div class="col-12">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-light"><i class="bx bxs-lock-open"></i>Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection