@extends('admin.layout.default')
@section('title','Admin Replies')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>{{ $module_name }}</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="post-reply-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Reply</th>
                                        <th>Comment</th>
                                        <th>Post</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>Status</th>
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
            $('#post-reply-datatable').DataTable({
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
                        data: 'reply', 
                        name: 'reply'
                    },
                    {
                        data: 'comment',
                        name: 'comments.comment'
                    },
                    {
                        data: 'post_name',
                        name: 'posts.title',
                        render: function(data, type, row) {
                            var post = "{{ url('blog') }}/" + row.slug;
                            return '<a href="' + post + '" target="_blank">' + data + '</a>';
                        }
                    },
                    {
                        data: 'name', 
                        name: 'name', 
                    },
                    { 
                        data: 'email', 
                        name: 'email'
                    },
                    { 
                        data: 'user_type', 
                        name: 'user_type'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            var status = "{{ url('admin/replies-change-status') }}/" + row.id;
                            return '<a href="' + status + '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'replies.created_at',
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