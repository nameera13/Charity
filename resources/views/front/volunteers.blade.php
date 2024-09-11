@extends('front.layout.default')
@section('title','Volunteers')
@section('front')

<div class="page-top" style="background-image: url('{{ asset('front/uploads/banner.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Volunteer</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Volunteer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="team pt_70">
    <div class="container">
        <div class="row">
            @foreach ($volunteers as $key => $value)                
                <div class="col-lg-3 col-md-6">
                    <div class="item pb_50">
                        <div class="photo">
                            <img src="{{ asset('admin/uploads/volunteers/'.$value->photo) }}" alt="" />
                        </div>
                        <div class="text">
                            <h2><a href="volunteer.html">{{ $value->name }}</a></h2>
                            <div class="designation">{{ $value->profession }}</div>
                            <div class="social">
                                <ul>
                                    @if ($value->facebook != '')                                        
                                        <li><a href="{{ $value->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif

                                    @if ($value->twitter != '') 
                                        <li><a href="{{ $value->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                    @endif

                                    @if ($value->linkedin != '')   
                                        <li><a href="{{ $value->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif

                                    @if ($value->instagram != '')  
                                        <li><a href="{{ $value->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-sm-12">
                {{ $volunteers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection