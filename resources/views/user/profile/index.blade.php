@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded">
                <div class="card-header text-center">
                    <h4>Update Your Profile</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Avatar Upload Field -->
                        <div class="form-group mb-2">
                            <label for="avatar" class="form-label">Profile Picture</label>
                            <input type="file" id="avatar" name="avatar"
                                class="form-control @error('avatar') is-invalid @enderror">
                            <small class="form-text text-light">Upload a square image for best results (e.g.,
                                200x200px).</small>
                        </div>


                        <!-- Name Field -->
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') ?? auth()->user()->name }}" required autofocus
                                placeholder="Enter your full name">
                        </div>

                        <!-- Email Field -->
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') ?? auth()->user()->email }}" required
                                placeholder="Enter your email address">
                        </div>

                        <!-- Username Field -->
                        <div class="form-group mb-4">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') ?? auth()->user()->username }}" required readonly>
                        </div>

                        <!-- Referral Field (if applicable) -->
                        <div class="form-group mb-4">
                            <label for="referral_id" class="form-label">Referral (optional)</label>
                            <input type="text" id="referral_id" name="referral_id"
                                class="form-control @error('referral_id') is-invalid @enderror"
                                value="{{ auth()->user()->upliner ? auth()->user()->upliner->username : "Direct" }}" placeholder="Referral ID (optional)" readonly>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
