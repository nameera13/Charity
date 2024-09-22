@extends('admin.layout.default')
@section('title','Admin Event Video')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Event ({{ $event->name }}) Videos</h1>
        <div class="">
            <a href="{{ url('admin/event') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Back to Events</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Section Items</h5>
                        <form action="{{ url('admin/event-video') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <div class="form-group mb-3">
                                <label for="">YouTube Video ID</label>
                                <input type="text" name="youtube_video_id" id="youtube_video_id" class="form-control">
                                @error('youtube_video_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="event-video-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th class="text-center">Video Preview</th>
                                        <th>YouTube Video ID</th>                                        
                                        <th>Created Date</th>
                                        <th class="tex-center min-w-100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>                                   
                                </tbody>
                            </table>
                        </div>
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
            var eventId = "{{ $event->id }}";

            $('#event-video-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! $module_route . '-datatable' !!}",
                    type: "GET",
                    data: function(d) {
                        d.event_id = eventId;
                    }
                },
                columns: [
                    { 
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'youtube_video_id', 
                        name: 'youtube_video_id', 
                        orderable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `<iframe class="i1" width="200" height="100" src="https://www.youtube.com/embed/${data}" 
                                title="YouTube video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                                encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                        }
                    },
                    {
                        data: 'youtube_video_id', 
                        name: 'youtube_video_id', 
                    },
                    { 
                        data: 'created_at', 
                        name: 'event_photos.created_at'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        responsivePriority: 1,
                        className: "text-center",
                        render: function(o) {
                            return `
                                <div style="display: flex; justify-content: center; gap: 5px;">
                                    <form action="{!! $module_route !!}/${o.id}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
@endpush