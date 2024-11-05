@extends('front.layout.default')
@section('front')

    @push('styles') 
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">       
        <style>
            .nav-link {
                color: #212529; 
                position: relative;
            }
            .nav-link.active {
                color: #0d6efd; 
            }
            .nav-link.active::after {
                content: "";
                position: absolute;
                left: 0;
                bottom: 0;
                background-color: #0d6efd; 
                width: 100%; 
                transform: scaleX(0.6); 
                transform-origin: bottom left; 
            }
            .card-icon {
                font-size: 2rem; 
                width: 100px; /* Fixed width for the icon */
                height: 90px; /* Fixed height for the icon */
                border-radius: 5px; /* Rounded corners */
                display: flex;
                align-items: center;
                justify-content: center;
                color: white; 
            }
            .tab-pane table {
                width: 100% !important;
                table-layout: auto;
            }

        </style>
    @endpush
 
    <div class="container-fluid m-4 p-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-3 rounded-2 p-4 shadow-sm sidebar me-3">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column fs-5" id="user_dashboard" role="tablist">
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="change-password-tab" data-bs-toggle="tab" href="#change-password" role="tab" aria-controls="change-password" aria-selected="false">
                                Change Password
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="event-ticket-tab" data-bs-toggle="tab" href="#event-ticket" role="tab" aria-controls="event-ticket" aria-selected="false">
                                Event Ticket
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="cause-donation-tab" data-bs-toggle="tab" href="#cause-donation" role="tab" aria-controls="cause-donation" aria-selected="false">
                                Cause Donation
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link text-danger" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
    
            <!-- Main Content -->
            <div class="col-md-8 ms-md-2 col-lg-8 ms-lg-2 rounded-2 shadow-sm">
                <div class="tab-content" id="user_dashboard_content">                    
                    <!-- Dashboard Tab -->
                    <div class="tab-pane" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                        <h2>Dashboard</h2>
                        <div class="row mt-3">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card border-light shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="card-icon bg-primary me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="card-title">Total Ticket Purchase</h4>
                                            <p class="card-text fs-4 mb-0">{{ $total_ticket }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card border-light shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="card-icon bg-primary me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="card-title">Total Amount Spent</h4>
                                            <p class="card-text fs-4 mb-0">{{ $total_price }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">                            
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card border-light shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="card-icon bg-primary me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="card-title">Total Cause Donations</h4>
                                            <p class="card-text fs-4 mb-0">{{ $total_ticket }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h2 class="text-start mb-4 mt-3">Profile</h2>
                        <form action="{{ url('/profile') }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ Auth::guard('web')->user()->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ Auth::guard('web')->user()->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="photo">Photo</label>
                                        <input type="file" class="form-control mb-2" name="photo" id="photo" onchange="userProfile()">
                                        @if (Auth::guard('web')->user()->photo != null)                                        
                                            <img id="profile_photo" src="{{ asset('front/uploads/profile/'.Auth::guard('web')->user()->photo) }}"
                                            alt="" class="img-fluid rounded-circle" style="width: 130px; height: 130px;">
                                        @else                                        
                                            <img id="profile_photo" src="{{ asset('front/uploads/no-img.png') }}" class="img-fluid rounded-circle" style="width: 130px; height: 130px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mb-4">
                                <button type="submit" class="btn btn-md btn-success">Update</button>
                            </div>
                        </form>
                    </div>
    
                    <!-- Change Password Tab -->
                    <div class="tab-pane" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                        <h2 class="text-center mb-4 mt-3">Change Password</h2>
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control" name="current_password" id="current_password" value="">
                                        @error('current_password', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" name="password" id="password" value="">
                                        @error('password', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="">
                                        @error('confirm_password', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mb-4">
                                <button type="submit" class="btn btn-md btn-success">Update Password</button>
                            </div>
                        </form>
                    </div>
    
                    <!-- Event Ticket Tab -->
                    <div class="tab-pane" id="event-ticket" role="tabpanel" aria-labelledby="event-ticket-tab">
                        <h2>Event Ticket</h2>
                        <p>Your Event Ticket information goes here.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="event-tickets-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Event Information</th>
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
                                        <th id="unit_price"></th>
                                        <th id="number_of_tickets"></th>
                                        <th id="total-price"></th>
                                    </tr>
                                </tfoot>
                                <tbody>                                   
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Cause Donation Tab -->
                    <div class="tab-pane" id="cause-donation" role="tabpanel" aria-labelledby="cause-donation-tab">
                        <h2>Cause Donation</h2>
                        <p>Your Cause Donation information goes here.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="cause-donations-datatable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Cause Information</th>
                                        <th>Payment ID</th>
                                        <th>Price</th>
                                        <th>Action</th>
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

    {{-- Invoice Modal --}}    
    <div class="modal fade" id="ticket_invoice_modal" tabindex="-1" aria-labelledby="ticket_invoice_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticket_invoice_modal_label">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                        <div class="invoice-number">Order #<span class="invoice-number"></span></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 invoice-to">
                                            <!-- Invoice To will be filled -->
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>Invoice Date</strong><br>
                                                <span class="invoice-date"></span>
                                                <br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title">Order Summary</div>
                                    <p class="section-lead">The detail about the ticket purchase is shown below</p>
                                    <hr class="invoice-above-table">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <tr>
                                                <th>SL</th>
                                                <th>Event Name</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Subtotal</th>
                                                <th class="text-right">Payment Gateway</th>
                                            </tr>
                                            <tbody class="invoice-summary">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-12 text-right">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Total</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg invoice-total"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="about-print-button">
                        <div class="text-md-right">
                            <a href="javascript:window.print();" class="btn btn-warning btn-icon icon-left text-white print-invoice-button"><i class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="donation_invoice_modal" tabindex="-1" aria-labelledby="donation_invoice_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donation_invoice_modal_label">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                        <div class="invoice-number">Order #<span class="invoice-number"></span></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 invoice-to">
                                            <!-- Invoice To will be filled -->
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>Invoice Date</strong><br>
                                                <span class="invoice-date"></span>
                                                <br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title">Order Summary</div>
                                    <p class="section-lead">The detail about the donation is shown below</p>
                                    <hr class="invoice-above-table">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <tr>
                                                <th>SL</th>
                                                <th>Cause Name</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-right">Payment Gateway</th>
                                            </tr>
                                            <tbody class="invoice-summary">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-12 text-right">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Total</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg invoice-total"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="about-print-button">
                        <div class="text-md-right">
                            <a href="javascript:window.print();" class="btn btn-warning btn-icon icon-left text-white print-invoice-button"><i class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script> 
        function userProfile() {
            const photo = document.getElementById('photo');
            const profilePhoto = document.getElementById('profile_photo');

            const file = photo.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    profilePhoto.src = e.target.result;
                    profilePhoto.classList.remove('d-none');
                };

                reader.readAsDataURL(file);
            }
        }


        $(document).ready(function(){

            $('#event-tickets-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('event-tickets-datatable') }}",
                    type: "GET",
                    data: function() {
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
                        data: 'created_at',
                        name: 'created_at',
                        width: '100px'
                    },
                    {
                        data: 'event_name',
                        name: 'events.name',
                        render: function (data, type, row) {
                            return `<a href="{{ url('events') }}/${row.event_slug}" target="_blank">${data}</a>`;
                        }
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
                                    <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#ticket_invoice_modal" data-id="${o.id}">See Invoice</a>
                                </div>
                            `;
                        }
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Calculate total unit price
                    var totalUnitPrice = api
                        .column(4, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return parseInt(a) + parseInt(b);
                        }, 0);

                    // Calculate total tickets
                    var totalTickets = api
                        .column(5, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b);
                        }, 0).toFixed(2);

                    // Calculate total price
                    var totalPrice = api
                        .column(6, { page: 'current' }) 
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b);
                        }, 0).toFixed(2);


                    $(api.column(4).footer()).html('<h5>' + totalUnitPrice + '</h5>');
                    $(api.column(5).footer()).html('<h5>' + totalTickets + '</h5>');
                    $(api.column(6).footer()).html('<h5>' + totalPrice + '</h5>');
                }

            });
            
            $('#ticket_invoice_modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); 
                var ticketId = button.data('id'); 

                $.ajax({
                    url: `/event-tickets/invoice/${ticketId}`, 
                    type: 'GET',
                    success: function(response) {
                        $('#ticket_invoice_modal .invoice-number').text(`Order #${response.payment_id}`);
                        $('#ticket_invoice_modal .invoice-title h2').text('Invoice');
                        $('#ticket_invoice_modal .invoice-to').html(`
                            <strong>Invoice To</strong><br>
                            ${response.user_data.name}<br>
                            ${response.user_data.email}
                        `);
                        $('#ticket_invoice_modal .invoice-date').text(response.created_at);
                        $('#ticket_invoice_modal .invoice-summary').html(`
                            <tr>
                                <td>1</td>
                                <td>${response.event.name}</td>
                                <td class="text-center">${response.unit_price}</td>
                                <td class="text-center">${response.number_of_tickets}</td>
                                <td class="text-right">${response.total_price}</td>
                                <td class="text-right">${response.payment_method}</td>
                            </tr>
                        `);
                        $('#ticket_invoice_modal .invoice-total').text(response.total_price);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Failed to load invoice data.');
                    }
                });
            });

            $('#cause-donations-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('cause-donations-datatable') }}",
                    type: "GET",
                    data: function() {
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
                        data: 'created_at',
                        name: 'created_at'
                    
                    },
                    {
                        data: 'cause_name',
                        name: 'causes.name',
                        render: function (data, type, row) {
                            return `<a href="{{ url('causes') }}/${row.cause_slug}" target="_blank">${data}</a>`;
                        }
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
                                    <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#donation_invoice_modal" data-id="${o.id}">See Invoice</a>
                                </div>
                            `;
                        }
                    }
                ]
            });

            $('#donation_invoice_modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); 
                var donationID = button.data('id'); 

                $.ajax({
                    url: `cause-donations/invoice/${donationID}`, 
                    type: 'GET',
                    success: function(response) {
                        $('#donation_invoice_modal .invoice-number').text(`Order #${response.payment_id}`);
                        $('#donation_invoice_modal .invoice-title h2').text('Invoice');
                        $('#donation_invoice_modal .invoice-to').html(`
                            <strong>Invoice To</strong><br>
                            ${response.user_data.name}<br>
                            ${response.user_data.email}
                        `);
                        $('#donation_invoice_modal .invoice-date').text(response.created_at);
                        $('#donation_invoice_modal .invoice-summary').html(`
                            <tr>
                                <td>1</td>
                                <td>${response.cause.name}</td>
                                <td class="text-center">${response.price}</td>
                                <td class="text-right">${response.payment_method}</td>
                            </tr>
                        `);
                        $('#donation_invoice_modal .invoice-total').text(response.price);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Failed to load invoice data.');
                    }
                });
            });
            
        });
        

    </script>
@endpush