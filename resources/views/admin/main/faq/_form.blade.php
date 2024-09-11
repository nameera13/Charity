@section('title', 'FAQ')

<div class="row">    
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Question</label>
            <input type="text" class="form-control" name="question" id="question" value="{{ isset($result) ? $result->question : old('question') }}">
            <span class="text-danger">
                <div class="error_question"></div>
            </span>
        </div>
    </div> 
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Answer</label>
            <textarea name="answer" class="form-control h_100" cols="30" rows="10">{{ isset($result) ? $result->answer : old('answer') }}</textarea>            
            <span class="text-danger">
                <div class="error_answer"></div>
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
                question: {
                    required: true,
                },
                answer: {
                    required: true,
                }
            },
            messages: {
                
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "question") {
                    error.insertAfter(".error_question");
                } else if (element.attr("name") == "answer") {
                    error.insertAfter(".error_answer");
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
