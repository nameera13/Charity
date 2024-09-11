@extends('front.layout.default')
@section('front')
    <div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Forgot Password</h2>
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Forgot Password</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content pt_70 pb_70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-12">
                    <div class="border rounded-3 p-4 shadow-sm bg-light">
                        <div class="mb-3">
                            <p class="text-muted">
                                No problem. Enter your email, and we'll send you a link to reset your password.
                            </p>
                        </div>    
                        @if (session('status'))
                            <div class="text-success mb-4">
                                {{ session('status') }}
                            </div>
                        @endif                    
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf            
                            <div class="login-form">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>                                
                                    @enderror
                                </div>                                                      
                                <div class="mb-3 text-end">
                                    <button type="submit" class="btn btn-primary bg-website">
                                        Send Reset Link
                                    </button>
                                </div>
                                
                            </div>
                        </form>
                        <div class="d-flex align-items-center my-3">
                            <div class="flex-grow-1 border-top"></div>
                            <span class="mx-2 text-muted">OR</span>
                            <div class="flex-grow-1 border-top"></div>
                        </div>
                        
                        <div class="mb-3 text-center">
                            <a href="{{ route('register') }}" class="primary-color">
                                Create New Account
                            </a>
                        </div>
                        <div class="border bg-website text-center py-2 mt-4 rounded-5">
                            <a href="{{ route('login') }}" class="text-white">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


