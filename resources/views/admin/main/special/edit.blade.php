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
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Heading</label>
                                        <input type="text" class="form-control" name="heading" id="heading" value="{{ isset($result) ? $result->heading : old('heading') }}">
                                        @error('heading')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Sub Heading</label>
                                        <input type="text" class="form-control" name="sub_heading" id="sub_heading" value="{{ isset($result) ? $result->sub_heading : old('sub_heading') }}">
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <label>Textarea</label>
                                        <textarea name="text" class="form-control text" cols="30" rows="10">{{ isset($result) ? $result->text : old('text') }}</textarea>            
                                        @error('text')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label>Button Text</label>
                                        <input type="text" class="form-control" name="btn_text" id="btn_text" value="{{ isset($result) ? $result->btn_text : old('btn_text') }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label>Button Link</label>
                                        <input type="text" class="form-control" name="btn_link" id="btn_link" value="{{ isset($result) ? $result->btn_link : old('btn_link') }}">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group mb-3">
                                        <label>Video</label>
                                        <input type="text" class="form-control mb-2" name="video" id="video" value="{{ $result->video }}">   
                                        @error('video')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Photo</label>
                                        <input type="file" class="form-control mb-2" name="photo" id="photo" onchange="specialImage()">
                            
                                        <img id="special_photo" src="{{ isset($result) ? asset('admin/uploads/specials/'.$result->photo) : '' }}" alt="" class="img-fluid {{ isset($result->photo) ? '' : 'd-none' }}" style="width: 240px; height: 140px;">
                            
                                        @error('photo')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>                                
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="hide" @if($result->status == 'hide') selected @endif>Hide</option>
                                            <option value="show" @if($result->status == 'show') selected @endif>Show</option>
                                        </select>
                                    </div>
                                </div>
                            </div>                               
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

    function specialImage() {
        const photo = document.getElementById('photo');
        const specialImage = document.getElementById('special_photo');

        const file = photo.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                specialImage.src = e.target.result;
                specialImage.classList.remove('d-none');
            };

            reader.readAsDataURL(file);
        }
    }
  </script>
@endpush