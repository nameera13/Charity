@extends('admin.layout.default')
@section('title','Admin Cause Donation')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Cause ({{ $cause->name }}) Tickets</h1>
        <div class="">
            <a href="{{ url('admin/cause') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Back to Causes</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="cause-donations-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>User</th>
                                        <th>Payment ID</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align: right;"><h5>Total Donations:</h5></th>
                                        <th id="total-price"></th>
                                    </tr>
                                </tfoot>
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

            $('#cause-donations-datatable').DataTable({
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
                        data: 'user_name',
                        name: 'users.name'
                    },
                    {
                        data: 'payment_id', 
                        name: 'payment_id', 
                        render: function(data, type, row) {
                            var maxLength = 40;
                            
                            if (data.length > maxLength) {
                                var line1 = data.substring(0, maxLength);
                                var line2 = data.substring(maxLength);
                                return line1 + '<br>' + line2;
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'price', 
                        name: 'price', 
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
                                    <a target="_blank" href="{!! $module_route !!}/invoice/${o.id}" class="btn btn-primary me-2">See Invoice</a>
                                </div>
                            `;
                        }
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    var totalPrice = api
                        .column(3, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b);
                        }, 0).toFixed(2);

                    $(api.column(3).footer()).html('<h5>' + totalPrice + '</h5>');
                }

            });
        });
    </script>
@endpush