@extends('layouts.auth')
@section('title', 'Forgot Password')

@section('style')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Brand logo--><a class="brand-logo" href="javascript:;">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:100px;">
                       
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{asset('assets/images/pages/forgot-password-v2.svg')}}" alt="Login V2" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Forgot password-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1">Forgot Password? 🔒</h2>
                            <p class="card-text mb-2">Enter your email and we'll send you instructions to reset your password</p>
                            <form id="forgot_password_form" class="auth-forgot-password-form mt-2" action="{{route('password.email')}}" method="POST">
                                @csrf
                                <div class="mb-1">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control" id="email" type="text" name="email" placeholder="john@example.com" aria-describedby="email" autofocus="" tabindex="1" />
                                </div>
                                <button type="submit" class="btn btn-primary w-100" tabindex="2">Send reset link</button>
                            </form>
                            <p class="text-center mt-2"><a href="{{route('login')}}"><i data-feather="chevron-left"></i> Back to login</a></p>
                        </div>
                    </div>
                    <!-- /Forgot password-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageJs')
    <script src="{{asset('pages/auth/send-email.js')}}"></script>
@endsection

@section('script')

@endsection
