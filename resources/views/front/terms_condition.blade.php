@extends('front.layout.default')
@section('title','Terms & Conditions')
@section('front')

<div class="page-top" style="background-image: url('{{ asset('uploads/setting/'.$global_setting_data->banner) }}')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Terms and Condition</h2>
                <div class="breadcrumb-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Terms and Conditions</li>
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
                {!! $terms->terms_content !!}
            </div>
        </div>
    </div>
</div>

@endsection