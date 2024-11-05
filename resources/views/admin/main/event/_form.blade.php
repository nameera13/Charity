@section('title', 'Event')

<div class="row">    
    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($result) ? $result->name : old('name') }}">
            <span class="text-danger">
                <div class="error_name"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label>Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ isset($result) ? $result->slug : old('slug') }}" readonly>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label>Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ isset($result) ? $result->location : old('location') }}">
            <span class="text-danger">
                <div class="error_location"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label>Date</label>
            <input id="datepicker" type="text" name="date" id="date" class="form-control" value="{{ isset($result) ? $result->date : old('date') }}">
            <span class="text-danger">
                <div class="error_date"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label>Time</label>
            <input id="timepicker" type="text" name="time" id="time" class="form-control" value="{{ isset($result) ? $result->time : old('time') }}">
            <span class="text-danger">
                <div class="error_time"></div>
            </span>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label>Price</label>
            <input type="text" name="price" id="price" class="form-control" value="{{ isset($result) ? $result->price : old('price') }}">
            <span class="text-danger">
                <div class="error_price"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label>Total Seat</label>
            <input type="text" name="total_seat" id="total_seat" class="form-control" value="{{ isset($result) ? $result->total_seat : old('total_seat') }}">
            <span class="text-danger">
                <div class="error_total_seat"></div>
            </span> 
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-sm-6">
        <div class="form-group mb-3">
            <label>Map</label>
            <textarea name="map" id="map" class="form-control h_100" cols="30" rows="10">{{ isset($result) ? $result->map : old('map') }}</textarea>
            <span class="text-danger">
                <div class="error_map"></div>
            </span>
        </div>
    </div>
    <div class="col-sm-6">
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
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Photo</label>
            <input type="file" class="form-control mb-2" name="featured_photo" id="featured_photo" onchange="Image()">

            <img id="photos" src="{{ isset($result) ? asset('uploads/events/'.$result->featured_photo) : '' }}" alt="" class="img-fluid {{ isset($result->featured_photo) ? '' : 'd-none' }}" style="width: 240px; height: 140px;">

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

        $('#datepicker').datepicker({
            dateFormat: 'yyyy-mm-dd',
            language: {
                today: 'Today',
                days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        });
        $('#timepicker').datepicker({
            language: 'en',
            timepicker: true,
            onlyTimepicker: true,
            timeFormat: 'hh:ii',
            dateFormat: null
        });

        $('#name').on('input', function() {
            var nameValue = $(this).val();
            
            var slugValue = nameValue.toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-').replace(/--+/g, '-');    
            $('#slug').val(slugValue);
            
            $.ajax({
                url: "{{ url('admin/event/check-name-unique') }}", 
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
                location: {
                    required: true,
                },
                date: {
                    required: true,
                },
                time: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true,
                    min: 0
                },
                total_seat: {
                    number: true,
                    min: 1
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
                price: {
                    number: "Please enter a valid number for the price.",
                    min: "Price cannot be less than 0."
                },
                total_seat: {
                    number: "Please enter a valid number for the total seat.",
                    min: "total seat cannot be less than 1."
                },
                photo: {
                    accept: "Only JPG, JPEG, and PNG formats are allowed."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "name") {
                    error.insertAfter(".error_name");
                } else if (element.attr("name") == "location") {
                    error.insertAfter(".error_location");
                } else if (element.attr("name") == "date") {
                    error.insertAfter(".error_date");
                } else if (element.attr("name") == "time") {
                    error.insertAfter(".error_time");
                } else if (element.attr("name") == "price") {
                    error.insertAfter(".error_price");
                } else if (element.attr("name") == "total_seat") {
                    error.insertAfter(".error_total_seat");
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
