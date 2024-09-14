@section('title', 'Post Category')

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
            <label for="">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug" value="{{ isset($result) ? $result->slug : old('slug') }}" readonly>    
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

        $('#name').on('input', function() {
            var nameValue = $(this).val();
            
            var slugValue = nameValue.toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-') .replace(/--+/g, '-');    

            $('#slug').val(slugValue);  
        });

        $("#form_validate").validate({
            rules: {
                name: {
                    required: true,
                }
            },
            messages: {
                
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "name") {
                    error.insertAfter(".error_name");
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
    });
   
</script>
@endpush
