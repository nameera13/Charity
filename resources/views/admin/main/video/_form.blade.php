@section('title', 'Video')

<div class="row">    
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Video Category</label>
            <select name="video_category_id" id="video_category_id" class="form-control">
                <option value="">Select Category</option>
                @if (isset($video_categories))
                    @foreach ($video_categories as $key => $value)
                        @php
                            $dis_video_category_selected = '';
                            if (isset($result)) {
                                if ($value->id == $result['video_category_id']) {
                                    $dis_video_category_selected = 'selected';
                                }
                            }
                        @endphp
                        <option {{ $dis_video_category_selected }} value="{{ $value->id }}">
                            {{ $value->name }}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger">
                <div class="error_video_category_id"></div>
            </span>
        </div>
    </div>    
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>Existing Video</label>
            <div class="">
                <iframe class="i1" width="200" height="100" src="https://www.youtube.com/embed/{{ $result->youtube_video_id }}" 
                    title="YouTube video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                    encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group mb-3">
            <label>YouTube Video ID</label>
            <input type="text" class="form-control mb-2" name="youtube_video_id" id="youtube_video_id" value="{{ $result->youtube_video_id }}">
            <span class="text-danger">
                <div class="error_youtube_video_id"></div>
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
                video_category_id: {
                    required: true,
                },
                youtube_video_id: {
                    required: true,
                }
            },
            messages: {
               
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "video_category_id") {
                    error.insertAfter(".error_video_category_id");
                } else if (element.attr("name") == "youtube_video_id") {
                    error.insertAfter(".error_youtube_video_id");
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
