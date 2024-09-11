@extends('front.layout.default')

@section('front')

<!-- Page Top Section -->
<div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-white">
                <h2 class="display-4">Verify Email</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Verify Email</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Page Content Section -->
<div class="page-content pt-5 pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- Content Container -->
                <div class="border rounded-3 p-4 shadow-sm bg-light">
                    <!-- Message Display -->
                    <div class="alert alert-info mb-4">
                        Thanks for signing up! Please verify your email by clicking the link we sent. If you didn’t receive it, you can request another one.
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="text-success mb-4">
                            A new verification link has been sent to your email.
                        </div>
                    @endif

                    <!-- Action Forms -->
                    <div class="d-flex justify-content-between">
                        <form method="POST" action="{{ route('verification.send') }}" class="me-2">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Resend Verification Email
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('logout') }}" class="ms-2">
                            @csrf
                            <button type="submit" class="btn btn-secondary">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
