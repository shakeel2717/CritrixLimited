@extends('layouts.auth')
@section('form')
    <div class="card-body">
        <div class="border p-4 rounded">
            <div class="text-center">
                <h3 class="">Reset your Password</h3>
            </div>
            <div class="form-body">
                <form class="row g-3" action="{{ route('password.store') }}" method="POST">
                    @csrf
                    <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id="inputEmailAddress"
                            placeholder="Email Address" value="{{ old('email', $request->email) }}" readonly>
                    </div>
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
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
                                id="password_confirmation" placeholder="Enter Password again">
                            <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-light"><i class="bx bxs-lock-open"></i>Reset Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
