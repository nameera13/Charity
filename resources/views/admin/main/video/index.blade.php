@extends('admin.layout.default')
@section('title','Admin Video')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>{{ $module_name }}</h1>
        <div class="">
            <a href="{{ $module_route }}/create" class="btn btn-primary"><i class="fas fa-plus"></i> Add {{ $module_name }}</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="video-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th class="text-center">Video Preview</th>
                                        <th>YouTube Video ID</th>
                                        <th>Category Name</th>
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
            $('#video-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! $module_route . '-datatable' !!}",
                    type: "GET",
                    data: function(d) {

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
                        data: 'category_name', 
                        name: 'video_categories.name'
                    },
                    {
                        data: 'created_at',
                        name: 'videos.created_at',
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
                                    <a href="{!! $module_route !!}/${o.id}/edit" class="btn btn-primary me-2"><i class="fas fa-edit"></i></a>
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