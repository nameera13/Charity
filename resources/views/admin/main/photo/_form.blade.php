@section('title', 'Photo')

<div class="row">    
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Photo Category</label>
            <select name="photo_category_id" id="photo_category_id" class="form-control">
                <option value="">Select Category</option>
                {{-- @foreach ($photo_categories as $value)
                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach --}}
                @if (isset($photo_categories))
                    @foreach ($photo_categories as $key => $value)
                        @php
                            $dis_photo_category_selected = '';
                            if (isset($result)) {
                                if ($value->id == $result['photo_category_id']) {
                                    $dis_photo_category_selected = 'selected';
                                }
                            }
                        @endphp
                        <option {{ $dis_photo_category_selected }} value="{{ $value->id }}">
                            {{ $value->name }}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger">
                <div class="error_photo_category_id"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Photo</label>
            <input type="file" class="form-control mb-2" name="photo" id="photo" onchange="Image()">

            <img id="photos" src="{{ isset($result) ? asset('admin/uploads/photos/'.$result->photo) : '' }}" alt="" class="img-fluid {{ isset($result->photo) ? '' : 'd-none' }}" style="width: 240px; height: 140px;">

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
                photo_category_id: {
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
                if (element.attr("name") == "photo_category_id") {
                    error.insertAfter(".error_photo_category_id");
                } else if (element.attr("name") == "photo") {
                    error.insertAfter(".error_photo");
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: [],
            submitHandler: function(form) {
                
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
