@extends('admin.layout.default')
@section('title','Admin Video Category')
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
                            <table class="table table-bordered" id="video-category-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
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
            $('#video-category-datatable').DataTable({
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
                        data: 'name', 
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'video_categories.created_at',
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        responsivePriority: 1,
                        targets: 0,
                        className: "text-center",
                        render: function(o) {
                        
                            return `
                                <a  href="{!! $module_route !!}/${o.id}/edit" class="btn btn-primary me-2"><i class="fas fa-edit"></i></a>
                                <form action="{!! $module_route !!}/${o.id}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
@endpush