@extends('admin.layout.default')
@section('title','Admin Send Message to All')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Send Message to All</h1>
        <div class="">
            <a href="{{ $module_route }}" class="btn btn-primary"><i class="fas fa-plus"></i>All Subscriber</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $module_route . '/send-message' }}" id="send_message" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">Subject</label>
                                <input type="text" name="subject" class="form-control">
                                <span class="text-danger">
                                    <div class="error_subject"></div>
                                </span> 
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Content</label>
                                <textarea name="content" class="form-control h_200"  cols="30" rows="10"></textarea>
                                <span class="text-danger">
                                    <div class="error_content"></div>
                                </span> 
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" id="submit_send_message" class="btn btn-primary">Send Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
         $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#send_message").validate({
                rules: {
                    subject: {
                        required: true,
                    },
                    content: {
                        required: true,
                    }
                    
                },
                messages: {
                   
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "subject") {
                        error.insertAfter(".error_subject");
                    } else if (element.attr("name") == "content") {
                        error.insertAfter(".error_content");
                    } else {
                        error.insertAfter(element);
                    }
                },
                ignore: [],
                submitHandler: function(form) {                
                    if ($("#send_message").valid()) {
                        var button = document.querySelector("#submit_send_message");
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