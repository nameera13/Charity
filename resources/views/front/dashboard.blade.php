@extends('front.layout.default')
@section('front')

    <style>
        .nav-link {
            color: #212529; 
            position: relative;
        }
        .nav-link.active {
            color: #0d6efd; 
        }
        .nav-link.active::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            background-color: #0d6efd; 
            width: 100%; 
            transform: scaleX(0.6); 
            transform-origin: bottom left; 
        }
    </style>

 
    <div class="container-fluid m-4 p-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-3 rounded-2 p-4 shadow-sm sidebar me-3">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column fs-5" id="user_dashboard" role="tablist">
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="change-password-tab" data-bs-toggle="tab" href="#change-password" role="tab" aria-controls="change-password" aria-selected="false">
                                Change Password
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="messages-tab" data-bs-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">
                                Messages
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="settings-tab" data-bs-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">
                                Settings
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link text-danger" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
    
            <!-- Main Content -->
            <div class="col-md-8 ms-md-2 col-lg-8 ms-lg-2 rounded-2 shadow-sm">
                <div class="tab-content" id="user_dashboard_content">
                    <!-- Profile Tab -->
                    <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h2 class="text-start mb-4 mt-3">Profile</h2>
                        <form action="{{ url('/profile') }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ Auth::guard('web')->user()->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ Auth::guard('web')->user()->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="photo">Photo</label>
                                        <input type="file" class="form-control mb-2" name="photo" id="photo" onchange="userProfile()">
                                        @if (Auth::guard('web')->user()->photo != null)                                        
                                            <img id="profile_photo" src="{{ asset('front/uploads/profile/'.Auth::guard('web')->user()->photo) }}"
                                            alt="" class="img-fluid rounded-circle" style="width: 130px; height: 130px;">
                                        @else                                        
                                            <img id="profile_photo" src="{{ asset('front/uploads/no-img.png') }}" class="img-fluid rounded-circle" style="width: 130px; height: 130px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mb-4">
                                <button type="submit" class="btn btn-md btn-success">Update</button>
                            </div>
                        </form>
                    </div>
    
                    <!-- Change Password Tab -->
                    <div class="tab-pane" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                        <h2 class="text-center mb-4 mt-3">Change Password</h2>
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control" name="current_password" id="current_password" value="">
                                        @error('current_password', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" name="password" id="password" value="">
                                        @error('password', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="">
                                        @error('confirm_password', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mb-4">
                                <button type="submit" class="btn btn-md btn-success">Update Password</button>
                            </div>
                        </form>
                    </div>
    
                    <!-- Messages Tab -->
                    <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                        <h2>Messages</h2>
                        <p>Your messages information goes here.</p>
                    </div>
    
                    <!-- Settings Tab -->
                    <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        <h2>Settings</h2>
                        <p>Your settings information goes here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('script')
    <script> 
        // $(document).ready(function() {
        //     $('#profile-tab').addClass('active');
        //     $('#profile').addClass('show active');

        //     $('#user_dashboard a').on('click', function(e) {
        //         e.preventDefault();
        //         $('#user_dashboard a').removeClass('active');
        //         $(this).addClass('active');
                
        //         var target = $(this).attr('href');
        //         $('.tab-pane').removeClass('show active');
        //         $(target).addClass('show active');
        //     });
        // });

        function userProfile() {
            const photo = document.getElementById('photo');
            const profilePhoto = document.getElementById('profile_photo');

            const file = photo.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    profilePhoto.src = e.target.result;
                    profilePhoto.classList.remove('d-none');
                };

                reader.readAsDataURL(file);
            }
        }

        document.querySelectorAll('#user_dashboard a[data-bs-toggle="tab"]').forEach(function (tabLink) {
            tabLink.addEventListener('shown.bs.tab', function (event) {
                localStorage.setItem('activeTab', event.target.id);
            });
        });

        let activeTabId = localStorage.getItem('activeTab');
        if (activeTabId) {
            let activeTab = document.getElementById(activeTabId);
            if (activeTab) {
                new bootstrap.Tab(activeTab).show();
            }
        }
        

    </script>
@endpush