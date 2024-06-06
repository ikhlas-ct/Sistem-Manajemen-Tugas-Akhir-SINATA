@extends('layout.master')
@section('title', 'Login')
@section('content')
    <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-4 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <form method="POST" action="{{ route('login.post') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" aria-describedby="usernameHelp"
                                        placeholder="Masukan username" value="{{ old('username') }}">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukan password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox"
                                            value="{{ old('password') }}" id="remember" name="remember">
                                        <label class="form-check-label text-dark" for="remember">
                                            Remember this Device
                                        </label>
                                    </div>
                                    <a class="text-primary fw-bold" href="./forgot-password.html">Forgot Password?</a>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 fs-5 mb-4 rounded-2">Login</button>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-5 mb-0 fw-bold">Belum punya akun?</p>
                                    <a class="text-primary fw-bold ms-2" href="./register.html">Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
