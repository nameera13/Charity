@section('title', 'Feature')

<div class="row">    
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Icon</label>
            <input type="text" class="form-control" name="icon" id="icon" value="{{ isset($result) ? $result->icon : old('icon') }}">
        </div>
    </div>    
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
            <textarea name="text" class="form-control h_100" cols="30" rows="10">{{ isset($result) ? $result->text : old('text') }}</textarea>            
            <span class="text-danger">
                <div class="error_text"></div>
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

        $("#form_validate").validate({
            rules: {
                heading: {
                    required: true,
                },                   
                text: {
                    required: true,
                }
            },
            messages: {
                
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "heading") {
                    error.insertAfter(".error_heading");
                } else if (element.attr("name") == "text") {
                    error.insertAfter(".error_text");
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: [], 
            submitHandler: function(form) {                
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

   
</script>
@endpush
