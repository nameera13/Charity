@extends('admin.layout.default')
@section('title','Admin Event Ticket')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Event ({{ $event->name }}) Tickets</h1>
        <div class="">
            <a href="{{ url('admin/event') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Back to Events</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="event-tickets-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>User</th>
                                        <th>Payment ID</th>
                                        <th>Unit Price</th>
                                        <th>Number of Tickets</th>                                        
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align: right;"><h5>Total Tickets:</h5></th>
                                        <th id="number_of_tickets"></th>
                                        <th id="total-price"></th>
                                        <th></th>
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
            var eventId = "{{ $event->id }}";

            $('#event-tickets-datatable').DataTable({
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
                        data: 'unit_price', 
                        name: 'unit_price', 
                    },
                    {
                        data: 'number_of_tickets', 
                        name: 'number_of_tickets', 
                    },
                    {
                        data: 'total_price', 
                        name: 'total_price', 
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
                                    <a href="{!! $module_route !!}/invoice/${o.id}" class="btn btn-primary me-2">See Invoice</a>
                                </div>
                            `;
                        }
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Calculate total tickets
                    var totalTickets = api
                        .column(4, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return parseInt(a) + parseInt(b);
                        }, 0);

                    // Calculate total price
                    var totalPrice = api
                        .column(5, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b);
                        }, 0).toFixed(2);

                    $(api.column(4).footer()).html('<h5>' + totalTickets + '</h5>');
                    $(api.column(5).footer()).html('<h5>' + totalPrice + '</h5>');
                }

            });
        });
    </script>
@endpush