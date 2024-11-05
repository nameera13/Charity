@extends('admin.layout.default')
@section('title','Admin Cause Photo')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Cause ({{ $cause->name }}) Photos</h1>
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
                        <form action="{{ url('admin/cause-photo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cause_id" value="{{ $cause->id }}">
                            <div class="form-group mb-3">
                                <label for="">Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control" onchange="Image()">

                                <img id="photos" src="" alt="" class="img-fluid {{ isset($request->photo) ? '' : 'd-none' }}" style="width: 240px; height: 140px;">

                                @error('photo')
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
                            <table class="table table-bordered" id="cause-photo-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Photo</th>
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
            var causeId = "{{ $cause->id }}";

            $('#cause-photo-datatable').DataTable({
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
                        data: 'photo', 
                        name: 'photo', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {

                            var photoUrl = data ? "{{ asset('uploads/cause-photo') }}/" + data : "{{ asset('uploads/no-img.png') }}";
                            return '<img src="' + photoUrl + '" alt="Photo" width="100" />';
                        }
                    },
                    { 
                        data: 'created_at', 
                        name: 'cause_photos.created_at'
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

        function Image() {
            const photo = document.getElementById('photo');
            const Image = document.getElementById('photos');

            const file = photo.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    Image.src = e.target.result;
                    Image.classList.remove('d-none');
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush