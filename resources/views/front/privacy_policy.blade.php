@extends('front.layout.default')
@section('title','Privacy Policy')
@section('front')

<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Privacy Policy</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Privacy Policy</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-content pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                {!! $privacy->privacy_content !!}
            </div>
        </div>
    </div>
</div>

@endsection