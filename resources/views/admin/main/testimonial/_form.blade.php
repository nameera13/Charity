@section('title', 'Feature')

<div class="row">    
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ isset($result) ? $result->name : old('name') }}">
            <span class="text-danger">
                <div class="error_name"></div>
            </span>
        </div>
    </div>    
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label for="">Designation</label>
            <input type="text" class="form-control" name="designation" id="designation" value="{{ isset($result) ? $result->designation : old('designation') }}">
            <span class="text-danger">
                <div class="error_designation"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Comment</label>
            <textarea name="comment" class="form-control h_100" cols="30" rows="10">{{ isset($result) ? $result->comment : old('comment') }}</textarea>            
            <span class="text-danger">
                <div class="error_comment"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Photo</label>
            <input type="file" class="form-control mb-2" name="photo" id="photo" onchange="Image()">

            <img id="testimonial_photo" src="{{ isset($result) ? asset('uploads/testimonials/'.$result->photo) : '' }}" alt="" class="img-fluid {{ isset($result->photo) ? '' : 'd-none' }}" style="width: 240px; height: 140px;">

            <span class="text-danger">
                <div class="error_photo"></div>
            </span>
        </div>
    </div>
</div>

@push('scripts')
<script>

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#form_validate").validate({
            rules: {
                name: {
                    required: true,
                },
                designation: {
                    required: true,
                },
                comment: {
                    required: true,
                },
                photo: {
                    required: function(element) {
                        // Only required if a new file is selected
                        return $("#photo")[0].files.length > 0 || !$("#photo").data('existing-photo');
                    },
                    accept: "image/jpg, image/jpeg, image/png"
                }
            },
            messages: {
                photo: {
                    required: "Please upload an image.",
                    accept: "Only JPG, JPEG, and PNG formats are allowed."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "name") {
                    error.insertAfter(".error_name");
                } else if (element.attr("name") == "designation") {
                    error.insertAfter(".error_designation");
                } else if (element.attr("name") == "comment") {
                    error.insertAfter(".error_comment");
                } else if (element.attr("name") == "photo") {
                    error.insertAfter(".error_photo");
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            submitHandler: function(form) {
                tinymce.get('text').save();
                
                if ($("#form_validate").valid()) {
                    var button = document.querySelector("#submit_form_button");
                    button.setAttribute("data-kt-indicator", "on");
                    form.submit();
                } else {
                    return false;
                }
            }
        });

        @if (isset($result->photo) && $result->photo)
            $("#photo").data('existing-photo', true);
        @endif
    });

    function Image() {
        const photo = document.getElementById('photo');
        const Image = document.getElementById('testimonial_photo');

        const file = photo.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                Image.src = e.target.result;
                Image.classList.remove('d-none');
            };

            reader.readAsDataURL(file);
        }
    }

   
</script>
@endpush
