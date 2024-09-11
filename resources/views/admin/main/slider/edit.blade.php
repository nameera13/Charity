@section('title', 'Slider')

<div class="row">
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label for="">Heading</label>
            <input type="text" class="form-control" name="heading" id="heading" value="{{ isset($result) ? $result->heading : old('heading') }}">
            <span class="text-danger">
                <div class="error_heading"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Textarea</label>
            <textarea name="text" class="form-control text" cols="30" rows="10">{{ isset($result) ? $result->text : old('text') }}</textarea>            
            <span class="text-danger">
                <div class="error_text"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Button Text</label>
            <textarea name="btn_text" class="form-control" cols="30" rows="10">{{ isset($result) ? $result->btn_text : old('btn_text') }}</textarea>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Button Link</label>
            <textarea name="btn_link" class="form-control" cols="30" rows="10">{{ isset($result) ? $result->btn_link : old('btn_link') }}</textarea>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Photo</label>
            <input type="file" class="form-control mb-2" name="photo" id="photo" onchange="sliderImage()">

            <img id="slider_photo" src="{{ isset($result) ? asset('admin/uploads/sliders/'.$result->photo) : '' }}" alt="" class="img-fluid {{ isset($result->photo) ? '' : 'd-none' }}" style="width: 240px; height: 140px;">

            <span class="text-danger">
                <div class="error_photo"></div>
            </span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        tinymce.init({
            selector: '.text',
            height: 300,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); 
                });
            }
        });

        $("#form_validate").validate({
            rules: {
                heading: {
                    required: true,
                },                   
                text: {
                    required: true,
                },
                photo: {
                    required: false,
                    accept: "image/jpeg, image/png, image/jpg"
                }
            },
            messages: {
                photo: {
                    required: "Please upload an image.",
                    accept: "Only JPG, JPEG, and PNG formats are allowed."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "heading") {
                    error.insertAfter(".error_heading");
                } else if (element.attr("name") == "text") {
                    error.insertAfter(".error_text");
                } else if (element.attr("name") == "photo") {
                    error.insertAfter(".error_photo");
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: [], 
            submitHandler: function(form) {
                tinymce.get('text').save();
                
                if($("#form_validate").valid()) {
                    var button = document.querySelector("#submit_form_button");
                    button.setAttribute("data-kt-indicator", "on");
                    form.submit();
                } else {
                    return false;
                }
            }
        });

    });

    function sliderImage() {
        const photo = document.getElementById('photo');
        const sliderImage = document.getElementById('slider_photo');

        const file = photo.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                sliderImage.src = e.target.result;
                sliderImage.classList.remove('d-none');
            };

            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
