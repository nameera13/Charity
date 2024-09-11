@extends('admin.layout.default')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1> Edit {{ $module_name }}</h1>
        <div class="">
            <a href="{{ $module_route }}" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ url($module_route . '/' . $result->id) }}" method="POST" enctype="multipart/form-data" class="form" id="form_validate" name="form_general" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @include("$module_view._form")                                 
                        </div>
                        
                        <div class="card-footer">
                            <!--begin::Action buttons-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Button-->
                                <a href="{{ $module_route }}" class="btn btn-light me-3">Cancel</a>
                                <!--end::Button-->
                                <!--begin::Button-->
                                <button type="submit" id="submit_form_button" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Action buttons-->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
    });
  </script>
@endpush