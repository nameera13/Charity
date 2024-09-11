@extends('front.layout.default')
@section('front')

<div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Create Account</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Create Account</li>
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
                    <form method="POST" action="{{ route('register') }}">
                        @csrf            
                        <div class="login-form">
                            <div class="mb-3">
                                <label for="" class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>                                
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password *</label>
                                <input type="password" class="form-control" name="password" id="password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary bg-website">
                                    Create Account
                                </button>
                            </div>
                        </div>
                    </form>                    
                    <div class="border border-secondary bg-light text-center py-2 mt-5 rounded-5">
                        <span class="me-2">Have an account?</span><a href="{{ route('login') }}" class="primary-color">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection