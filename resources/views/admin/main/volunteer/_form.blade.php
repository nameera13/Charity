@section('title','Volunteer')

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group mb-3">
                <label>Photo</label>
                <div class="">
                    <img id="volunteer_photo" src="{{ isset($result) ? asset('uploads/volunteers/'.$result->photo) : '' }}" alt="" class="img-fluid {{ isset($result->photo) ? '' : 'd-none' }}" style="width: 240px; height: 180px;">
                </div>
                <input type="file" class="form-control mb-2" name="photo" id="photo" onchange="Image()">
                <span class="text-danger">
                    <div class="error_photo"></div>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ isset($result) ? $result->name : old('name') }}">
                <span class="text-danger">
                    <div class="error_name"></div>
                </span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Profession</label>
                <input type="text" class="form-control" name="profession" id="profession" value="{{ isset($result) ? $result->profession : old('profession') }}">
                <span class="text-danger">
                    <div class="error_profession"></div>
                </span>
            </div>
        </div>
    </div>
    <div class="row">   
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label>Address</label>
                <input type="text" class="form-control" name="address" id="address" value="{{ isset($result) ? $result->address : old('address') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ isset($result) ? $result->email : old('email') }}">
            </div>
        </div> 
    </div>  
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ isset($result) ? $result->phone : old('phone') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Website</label>
                <input type="text" class="form-control" name="website" id="website" value="{{ isset($result) ? $result->website : old('website') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Facebook</label>
                <input type="text" class="form-control" name="facebook" id="facebook" value="{{ isset($result) ? $result->facebook : old('facebook') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Twitter</label>
                <input type="text" class="form-control" name="twitter" id="twitter" value="{{ isset($result) ? $result->twitter : old('twitter') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Linkedin</label>
                <input type="text" class="form-control" name="linkedin" id="linkedin" value="{{ isset($result) ? $result->linkedin : old('linkedin') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label for="">Instagram</label>
                <input type="text" class="form-control" name="instagram" id="instagram" value="{{ isset($result) ? $result->instagram : old('instagram') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group mb-3">
                <label>Details</label>
                <textarea name="detail" class="form-control h_100" cols="30" rows="10">{{ isset($result) ? $result->detail : old('detail') }}</textarea>            
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
                profession: {
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
                } else if (element.attr("name") == "profession") {
                    error.insertAfter(".error_profession");
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
        const Image = document.getElementById('volunteer_photo');

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
