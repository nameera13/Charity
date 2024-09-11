@extends('admin.layout.default')
@section('title','Admin Feature')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>{{ $module_name }}</h1>
        <div class="">
            <a href="{{ $module_route }}/create" class="btn btn-primary"><i class="fas fa-plus"></i> Add Feature</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Section Items</h5>
                        <form action="{{ url('admin/feature-section-item') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">Existing Photo</label>
                                <div class="">
                                    <img src="{{ asset('admin/uploads/feature-item/'.$feature_section_items->photo) }}" alt="" style="width:100%;" class="w_200">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Change Photo</label>
                                <input type="file" name="photo" id="photo">
                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="hide" @if($feature_section_items->status == "hide") selected @endif>Hide</option>
                                            <option value="show" @if($feature_section_items->status == "show") selected @endif>Show</option>
                                        </select>
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="feature-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Icon</th>
                                        <th>Heading</th>
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
            $('#feature-datatable').DataTable({
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
                        data: 'icon',
                        name: 'icon',
                        render: function(data, type, row) {
                            return '<i class="' + data + '" style="font-size: 24px;"></i>';
                        },
                        orderable: false,
                        searchable: false
                    },

                    { 
                        data: 'heading', 
                        name: 'heading'
                    },
                    {
                        data: 'created_at',
                        name: 'features.created_at',
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