@section('title', 'Posts')

<div class="row">    
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Post Category</label>
            <select name="post_category_id" id="post_category_id" class="form-control">
                <option value="">Select Category</option>
                @if (isset($post_categories))
                    @foreach ($post_categories as $key => $value)
                        @php
                            $dis_post_category_selected = '';
                            if (isset($result)) {
                                if ($value->id == $result['post_category_id']) {
                                    $dis_post_category_selected = 'selected';
                                }
                            }
                        @endphp
                        <option {{ $dis_post_category_selected }} value="{{ $value->id }}">
                            {{ $value->name }}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger">
                <div class="error_post_category_id"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label for="">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ isset($result) ? $result->title : old('title') }}">
            <span class="text-danger">
                <div class="error_title"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label for="">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug" value="{{ isset($result) ? $result->slug : old('slug') }}" readonly>
            <span class="text-danger">
                <div class="error_slug"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Short Description</label>
            <textarea name="short_description" class="form-control h_100" cols="30" rows="10">{{ isset($result) ? $result->short_description : old('short_description') }}</textarea>            
            <span class="text-danger">
                <div class="error_short_description"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control description" cols="30" rows="10">{{ isset($result) ? $result->description : old('description') }}</textarea>            
            <span class="text-danger">
                <div class="error_description"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Photo</label>
            <input type="file" class="form-control mb-2" name="photo" id="photo" onchange="Image()">

            <img id="photos" src="{{ isset($result) ? asset('uploads/posts/'.$result->photo) : '' }}" alt="" class="img-fluid {{ isset($result->photo) ? '' : 'd-none' }}" style="width: 240px; height: 140px;">

            <span class="text-danger">
                <div class="error_photo"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Tags</label>
            <select name="tags[]" class="form-control select2_tags" multiple="multiple">
                @if(isset($result))
                    @for ($i = 0; $i < count($post_tags); $i++)
                        <option value="{{ $post_tags[$i] }}" selected>{{ $post_tags[$i] }}</option>
                    @endfor
                @endif
            </select>
        </div>
    </div>
</div>


@if(!isset($result) || !$result)
<div class="row">
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label>Send Email to Subscribers?</label>
            <select name="email_send" class="form-select">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
    </div>
</div>
@endif


@push('scripts')
<script>

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        tinymce.init({
            selector: '.description',
            height: 300,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); 
                });
            }
        });

        $('#title').on('input', function() {
            var titleValue = $(this).val();
            
            var slugValue = titleValue.toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-').replace(/--+/g, '-');    
            $('#slug').val(slugValue);
            
            $.ajax({
                url: "{{ url('admin/post/check-title-unique') }}", 
                method: 'POST',
                data: {
                    title: titleValue,
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    if (response.exists) {
                        $('#title').addClass('is-invalid'); 
                        $('.error_title').text('This title is already in use.').show(); 
                    } else {
                        $('#title').removeClass('is-invalid');
                        $('.error_title').text('').hide();
                    }
                }
            });
        });

        $("#form_validate").validate({
            rules: {
                post_category_id: {
                    required: true,
                },
                title: {
                    required: true,
                },
                short_description: {
                    required: true,
                    maxlength: 120
                },
                description: {
                    required: true,
                },
                photo: {
                    required: function(element) {
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
                if (element.attr("name") == "post_category_id") {
                    error.insertAfter(".error_post_category_id");
                } else if (element.attr("name") == "title") {
                    error.insertAfter(".error_title");
                } else if (element.attr("name") == "short_description") {
                    error.insertAfter(".error_short_description");
                } else if (element.attr("name") == "description") {
                    error.insertAfter(".error_description");
                } else if (element.attr("name") == "photo") {
                    error.insertAfter(".error_photo");
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            submitHandler: function(form) {
                tinymce.get('description').save();
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
