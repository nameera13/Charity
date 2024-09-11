@extends('admin.layout.default')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1> Edit {{ $module_name }}</h1>
        <div class="">
            <a href="{{ $module_route }}" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ url($module_route . '/' . $result->id) }}" method="POST" enctype="multipart/form-data" class="form" id="form_validate" name="form_general" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Counter 1 - Number</label>
                                        <input type="text" class="form-control" name="counter1_number" id="counter1_number" value="{{ isset($result) ? $result->counter1_number : old('counter1_number') }}">
                                        <span class="text-danger">
                                            <div class="error_counter1_number"></div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Counter 1 - Name</label>
                                        <input type="text" class="form-control" name="counter1_name" id="counter1_name" value="{{ isset($result) ? $result->counter1_name : old('counter1_name') }}">                                        
                                        <span class="text-danger">
                                            <div class="error_counter1_name"></div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Counter 2 - Number</label>
                                        <input type="text" class="form-control" name="counter2_number" id="counter2_number" value="{{ isset($result) ? $result->counter2_number : old('counter2_number') }}">
                                        <span class="text-danger">
                                            <div class="error_counter2_number"></div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Counter 2 - Name</label>
                                        <input type="text" class="form-control" name="counter2_name" id="counter2_name" value="{{ isset($result) ? $result->counter2_name : old('counter2_name') }}">
                                        <span class="text-danger">
                                            <div class="error_counter2_name"></div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Counter 3 - Number</label>
                                        <input type="text" class="form-control" name="counter3_number" id="counter3_number" value="{{ isset($result) ? $result->counter3_number : old('counter3_number') }}">
                                        <span class="text-danger">
                                            <div class="error_counter3_number"></div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Counter 3 - Name</label>
                                        <input type="text" class="form-control" name="counter3_name" id="counter3_name" value="{{ isset($result) ? $result->counter3_name : old('counter3_name') }}">
                                        <span class="text-danger">
                                            <div class="error_counter3_name"></div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Counter 4 - Number</label>
                                        <input type="text" class="form-control" name="counter4_number" id="counter4_number" value="{{ isset($result) ? $result->counter4_number : old('counter4_number') }}">
                                        <span class="text-danger">
                                            <div class="error_counter4_number"></div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="">Counter 4 - Name</label>
                                        <input type="text" class="form-control" name="counter4_name" id="counter4_name" value="{{ isset($result) ? $result->counter4_name : old('counter4_name') }}">
                                        <span class="text-danger">
                                            <div class="error_counter4_name"></div>
                                        </span>
                                    </div>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="hide" @if($result->status == "hide") selected @endif>Hide</option>
                                        <option value="show" @if($result->status == "show") selected @endif>Show</option>
                                    </select> 
                                    <span class="text-danger">
                                        <div class="error_status"></div>
                                    </span>   
                                </div>    
                            </div>                             
                        </div>
                        
                        <div class="card-footer">
                            <!--begin::Action buttons-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Button-->
                                <a href="{{ $module_route }}" class="btn btn-light me-3">Cancel</a>
                                <!--end::Button-->
                                <!--begin::Button-->
                                <button type="submit" id="submit_form_button" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                </button>
                                <!--end::Button-->
                            </div>
                            <!--end::Action buttons-->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
        $("#form_validate").validate({
            rules: {
                counter1_number: {
                    required: true,
                }, 
                counter1_name: {
                    required: true,
                }, 
                counter2_number: {
                    required: true,
                }, 
                counter2_name: {
                    required: true,
                }, 
                counter3_number: {
                    required: true,
                }, 
                counter3_name: {
                    required: true,
                }, 
                counter4_number: {
                    required: true,
                }, 
                counter4_name: {
                    required: true,
                },
                status: {
                    required: true,
                }                            
            },
            messages: {
              
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "counter1_number") {
                    error.insertAfter(".error_counter1_number");
                } else if (element.attr("name") == "counter1_name") {
                    error.insertAfter(".error_counter1_name");
                } else if (element.attr("name") == "counter2_number") {
                    error.insertAfter(".error_counter2_number");
                } else if (element.attr("name") == "counter2_name") {
                    error.insertAfter(".error_counter2_name");
                } else if (element.attr("name") == "counter3_number") {
                    error.insertAfter(".error_counter3_number");
                } else if (element.attr("name") == "counter3_name") {
                    error.insertAfter(".error_counter3_name");
                } else if (element.attr("name") == "counter4_number") {
                    error.insertAfter(".error_counter4_number");
                } else if (element.attr("name") == "counter4_name") {
                    error.insertAfter(".error_counter4_name");
                } else if (element.attr("name") == "status") {
                    error.insertAfter(".error_status");
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