@extends('admin.layout.default')
@section('title','Admin Cause Donation Invoice')
@section('admin')
    
<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Invoice</h1>
    </div>
    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <h2>Invoice</h2>
                            <div class="invoice-number">Order #{{ $cause_donation->payment_id }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Invoice To</strong><br>
                                    {{ $user_data->name }}<br>
                                    {{ $user_data->email }}
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Invoice Date</strong><br>
                                    {{ $cause_donation->created_at->format('d M Y') }}
                                    <br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">Order Summary</div>
                        <p class="section-lead">The detail about the donation is shown below:</p>
                        <hr class="invoice-above-table">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th>SL</th>
                                    <th>Event Name</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-right">Payment Gateway</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        @php
                                            $cause = App\Models\Cause::find($cause_donation->cause_id);
                                        @endphp
                                        {{ $cause->name }}
                                    </td>
                                    <td class="text-center">{{ $cause_donation->price }}</td>
                                    <td class="text-right">{{ $cause_donation->payment_method }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-12 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Total</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">{{ $cause_donation->price }}</div>
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
</section>
@endsection