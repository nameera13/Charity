@extends('admin.layout.default')
@section('title','Admin Cause Faq')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Cause ({{ $cause->name }}) FAQs</h1>
        <div class="">
            <a href="{{ url('admin/cause') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Back to Causes</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Section Items</h5>
                        <form action="{{ url('admin/cause-faq') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cause_id" value="{{ $cause->id }}">
                            <div class="form-group mb-3">
                                <label for="">Question</label>
                                <input type="text" name="question" id="question" class="form-control">
                                @error('question')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Answer</label>
                                <textarea name="answer" class="form-control h_150" id="answer" cols="30" rows="10"></textarea>
                                @error('answer')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="cause-video-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Question</th>                                        
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Cause FAQs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="">Question</label>
                        <input type="text" name="edit_question" id="edit_question" class="form-control">
                        @error('edit_question')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Answer</label>
                        <textarea name="edit_answer" class="form-control h_150" id="edit_answer" cols="30" rows="10"></textarea>
                        @error('edit_answer')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="cause_id" id="faq_id" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editForm" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var causeId = "{{ $cause->id }}";

            $('#cause-video-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! $module_route . '-datatable' !!}",
                    type: "GET",
                    data: function(d) {
                        d.cause_id = causeId;
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
                        data: 'question', 
                        name: 'question'
                    },
                    { 
                        data: 'created_at', 
                        name: 'cause_faqs.created_at'
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
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${o.id}" data-question="${o.question}" data-answer="${o.answer}" class="btn btn-primary me-2 edit-cause-faq">
                                        <i class="fas fa-edit"></i>
                                    </a>
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

            $(document).on('click', '.edit-cause-faq', function() {
                const faqId = $(this).data('id');
                const question = $(this).data('question');
                const answer = $(this).data('answer');

                $('#faq_id').val(faqId);
                $('#edit_question').val(question);
                $('#edit_answer').val(answer);
                $('#editForm').attr('action', `{!! $module_route !!}/${faqId}`);
            });


        });
    </script>
@endpush