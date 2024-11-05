@extends('admin.layout.default')
@section('title','Admin Terms Page')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Terms Page</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ url('admin/terms') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <textarea name="terms_content" class="form-control text" cols="30" rows="10">{{ $terms->terms_content }}</textarea>       
                                    </div>
                                </div>
                            </div>
                                                        
                        </div>
                        
                        <div class="card-footer">
                            <!--begin::Action buttons-->
                            <div class="d-flex justify-content-start">                               
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
        tinymce.init({
            selector: '.text',
            height: 300,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); 
                });
            }
        });
    });

</script>
@endpush
