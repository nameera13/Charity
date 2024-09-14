@extends('front.layout.default')
@section('title','Volunteers')
@section('front')

<div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $volunteer_details->name }}</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('volunteers') }}">Volunteers</a></li>
                        <li class="breadcrumb-item active">{{ $volunteer_details->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="team-single pt_70 pb_70 bg_f3f3f3">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="photo">
                    <img src="{{ asset('admin/uploads/volunteers/'.$volunteer_details->photo) }}" alt="">
                </div>
            </div>
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Name</td>
                            <td>{{ $volunteer_details->name }}</td>
                        </tr>
                        <tr>
                            <td>Designation</td>
                            <td>{{ $volunteer_details->profession }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $volunteer_details->address }}</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>{{ $volunteer_details->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $volunteer_details->phone }}</td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td><a href="{{ $volunteer_details->website }}" target="_blank">{{ $volunteer_details->website }}</a></td>
                        </tr>
                        <tr>
                            <td>Social Media</td>
                            <td>
                                <ul>
                                    @if ($volunteer_details->facebook != '')                                        
                                        <li><a href="{{ $volunteer_details->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif

                                    @if ($volunteer_details->twitter != '') 
                                        <li><a href="{{ $volunteer_details->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                    @endif

                                    @if ($volunteer_details->linkedin != '')   
                                        <li><a href="{{ $volunteer_details->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif

                                    @if ($volunteer_details->instagram != '')  
                                        <li><a href="{{ $volunteer_details->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        
            <div class="col-md-12 mt_30">
                <h4>Biography</h4>
                <div class="description">
                    <p>
                        {{ $volunteer_details->detail }}    
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection