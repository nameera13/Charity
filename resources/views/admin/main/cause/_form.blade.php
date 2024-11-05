@section('title', 'Cause')

<div class="row">    
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($result) ? $result->name : old('name') }}">
            <span class="text-danger">
                <div class="error_name"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label>Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ isset($result) ? $result->slug : old('slug') }}" readonly>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label>Goal</label>
            <input type="text" name="goal" id="goal" class="form-control" value="{{ isset($result) ? $result->goal : old('goal') }}">
            <span class="text-danger">
                <div class="error_goal"></div>
            </span>
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Short Description</label>
            <textarea name="short_description" id="short_description" class="form-control h_100" cols="30" rows="10">{{ isset($result) ? $result->short_description : old('short_description') }}</textarea>
            <span class="text-danger">
                <div class="error_short_description"></div>
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label for="">Description</label>
            <textarea name="description" class="form-control text" cols="30" rows="10">{{ isset($result) ? $result->description : old('description') }}</textarea>       
            <span class="text-danger">
                <div class="error_description"></div>
            </span>     
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label for="">Is Featured?</label>
            <select name="is_featured" class="form-control">
                <option value="Yes" @if(isset($result) && $result->is_featured == "Yes") selected @endif>Yes</option>
                <option value="No" @if(isset($result) && $result->is_featured == "No") selected @endif>No</option>
            </select>
            <span class="text-danger">
                <div class="error_is_featured"></div>
            </span>     
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label>Photo</label>
            <input type="file" class="form-control mb-2" name="featured_photo" id="featured_photo" onchange="Image()">

            <img id="photos" src="{{ isset($result) ? asset('uploads/causes/'.$result->featured_photo) : '' }}" alt="" class="img-fluid {{ isset($result->featured_photo) ? '' : 'd-none' }}" style="width: 240px; height: 140px;">

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

        tinymce.init({
            selector: '.text',
            height: 300,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); 
                });
            }
        });

        $('#name').on('input', function() {
            var nameValue = $(this).val();
            
            var slugValue = nameValue.toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-').replace(/--+/g, '-');    
            $('#slug').val(slugValue);
            
            $.ajax({
                url: "{{ url('admin/cause/check-name-unique') }}", 
                method: 'POST',
                data: {
                    name: nameValue,
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    if (response.exists) {
                        $('#name').addClass('is-invalid'); 
                        $('.error_name').text('This name is already in use.').show(); 
                    } else {
                        $('#name').removeClass('is-invalid');
                        $('.error_name').text('').hide();
                    }
                }
            });
        });


        $("#form_validate").validate({
            rules: {
                name: {
                    required: true,
                },
                goal: {
                    required: true,
                },
                short_description: {
                    required: true,
                    maxlength: 120
                },
                description: {
                    required: true,
                },
                is_featured: {
                    required: true,
                },
                featured_photo: {
                    required: function(element) {
                        return $("#featured_photo")[0].files.length > 0 || !$("#featured_photo").data('existing-photo');
                    },
                    accept: "image/jpg, image/jpeg, image/png"
                }
            },
            messages: {
                featured_photo: {
                    accept: "Only JPG, JPEG, and PNG formats are allowed."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "name") {
                    error.insertAfter(".error_name");
                } else if (element.attr("name") == "goal") {
                    error.insertAfter(".error_goal");
                } else if (element.attr("name") == "short_description") {
                    error.insertAfter(".error_short_description");
                } else if (element.attr("name") == "description") {
                    error.insertAfter(".error_description");
                } else if (element.attr("name") == "is_featured") {
                    error.insertAfter(".error_is_featured");
                } else if (element.attr("name") == "featured_photo") {
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

        @if (isset($result->featured_photo) && $result->featured_photo)
            $("#featured_photo").data('existing-photo', true);
        @endif
    });

    function Image() {
        const photo = document.getElementById('featured_photo');
        const Image = document.getElementById('photos');

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
