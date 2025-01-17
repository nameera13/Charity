@extends('admin.layout.default')
@section('title','Admin Cause')
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
                            <table class="table table-bordered" id="event-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Goal</th>
                                        <th>Raised</th>
                                        <th>Is Featured?</th>
                                        <th>Options</th>
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
            $('#event-datatable').DataTable({
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
                        data: 'featured_photo', 
                        name: 'featured_photo', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {

                            var photoUrl = data ? "{{ asset('uploads/causes') }}/" + data : "{{ asset('uploads/no-img.png') }}";
                            return '<img src="' + photoUrl + '" alt="Photo" width="100" />';
                        }
                    },
                    { 
                        data: 'name', 
                        name: 'name'
                    },
                    { 
                        data: 'goal', 
                        name: 'goal'
                    },
                    { 
                        data: 'raised', 
                        name: 'raised'
                    },
                    { 
                        data: 'is_featured', 
                        name: 'is_featured'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex flex-column">
                                <a href="{{ $module_route }}/photo/${row.id}" class="btn btn-sm btn-primary text-white mb_5">Photo Gallery</a>
                                <a href="{{ $module_route }}/video/${row.id}" class="btn btn-sm btn-success mb_5">Video Gallery</a>
                                <a href="{{ $module_route }}/faq/${row.id}" class="btn btn-sm btn-info mb_5">FAQ</a>
                                <a href="{{ $module_route }}/donations/${row.id}" class="btn btn-sm btn-warning mb_5">Donations</a>
                            </div> `;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'causes.created_at',
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