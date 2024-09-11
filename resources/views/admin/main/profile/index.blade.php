@extends('admin.layout.default')
@section('title','Admin Profile')
@section('admin')
    
<section class="section">
    <div class="section-header">
        <h1>Profile</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('admin/update-profile') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    @if (Auth::guard('admin')->user()->photo != null)                                        
                                        <img src="{{ asset('admin/uploads/profile/'.Auth::guard('admin')->user()->photo) }}"
                                         alt="" class="profile-photo w_100_p">
                                    @else                                        
                                        <img src="{{ asset('admin/uploads/no-img.png') }}" alt="" class="profile-photo w_100_p">
                                    @endif

                                    <input type="file" class="mt_10" name="photo">
                                </div>
                                <div class="col-md-9">
                                    <div class="mb-4">
                                        <label class="form-label">Name *</label>
                                        <input type="text" class="form-control" name="name" value="{{ Auth::guard('admin')->user()->name }}" autocomplete="off">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Email *</label>
                                        <input type="text" class="form-control" name="email" value="{{ Auth::guard('admin')->user()->email }}" autocomplete="off">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Retype Password</label>
                                        <input type="password" class="form-control" name="confirm_password">
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label"></label>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection