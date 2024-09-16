@extends('admin.layout.default')
@section('title','Admin Comments')
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
                            <table class="table table-bordered" id="post-comments-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Comment</th>
                                        <th>Post</th>
                                        <th>Name</th>
                                        <th>Email</th>
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

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Reply to Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="replyForm">
                    <input type="hidden" name="comment_id" id="comment_id">
                    <div class="form-group">
                        <textarea class="form-control h_100" id="reply" name="reply" rows="10" cols="30" placeholder="Reply"></textarea>
                        <span class="text-danger">
                            <div class="error_reply"></div>
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit_reply">Submit Reply</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#post-comments-datatable').DataTable({
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
                        data: 'comment',
                        name: 'comment',
                        render: function(data, type, row) {
                            return data + ' <a href="javascript:void(0)" class="reply-link" data-id="' + row.id + '" data-toggle="modal" data-target="#replyModal">Reply</a>';
                        }
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
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            var status = "{{ url('admin/comments-change-status') }}/" + row.id;
                            return '<a href="' + status + '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'comments.created_at',
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

            $(document).on('click', '.reply-link', function() {
                var commentId = $(this).data('id');
                $('#comment_id').val(commentId); 
                $('#replyModal').modal('show');
            });

            $("#replyForm").validate({
                rules: {
                    reply: {
                        required: true,
                    }
                },
                messages: {
                    
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "reply") {
                        error.insertAfter(".error_reply");
                    } else {
                        error.insertAfter(element);
                    }
                },
                ignore: [],
                submitHandler: function(form) {
                    var button = document.querySelector("#submit_reply");
                    button.setAttribute("data-kt-indicator", "on");
                    
                    var commentId = $('#comment_id').val();
                    var replyText = $('#reply').val();

                    $.ajax({
                        url: '{{ url("admin/replies") }}',
                        method: 'POST',
                        data: {
                            comment_id: commentId,
                            reply: replyText,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#replyModal').modal('hide');
                            iziToast.success({
                                position: 'topRight',
                                message: response.message
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                            iziToast.error({
                                message: 'An error occurred while submitting your reply.'
                            });
                        },
                        complete: function() {
                            button.removeAttribute("data-kt-indicator");
                        }
                    });
                    
                    return false;
                }
            });

        });
    </script>
@endpush