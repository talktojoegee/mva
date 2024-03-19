@extends('layouts.master-layout')
@section('current-page')
    Invoice Details
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-2"></i>
                                {!! session()->get('success') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-close me-2"></i>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                            @if(($invoice->status == 0) && ($invoice->issued_by != \Illuminate\Support\Facades\Auth::user()->id))
                            <div class="row mb-2">
                                <div class="col-md-12 d-flex justify-content-end ">
                                    <form action="{{ route("approve-invoice") }}" method="post">
                                        @csrf
                                        <input type="hidden" name="invoice" value="{{ $invoice->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Approve Invoice <i class="bx bx-check-circle"></i> </button>
                                    </form>

                                </div>
                            </div>
                            @endif

                            <div class="row" >
                                <div class="col-lg-12" >
                                    <div class="card" >
                                        <div class="card-body" >
                                            <div class="invoice-title" >
                                                <h4 class="float-end font-size-16">Ref. No. {{$invoice->ref_code ?? '' }}</h4>
                                                <div class="auth-logo mb-4" >
                                                    <img src="/assets/drive/logo/logo.png" alt="logo" class="auth-logo-dark" height="90">
                                                    <img src="/assets/drive/logo/logo.png" alt="logo" class="auth-logo-light" height="90">
                                                </div>
                                                <h5 class="text-center">Vehicle Registration</h5>
                                            </div>
                                            <hr>
                                            <div class="row" >
                                                <div class="col-sm-6" >
                                                    <address>
                                                        <strong>Vehicle Details:</strong><br>
                                                        {{$invoice->getVehicle->getVehicleBrand->name ?? '' }} {{$invoice->getVehicle->getVehicleModel->vm_name ?? '' }}({{$invoice->getVehicle->getVehicleColor->name ?? '' }}) <br>
                                                        <strong>Chassis No. </strong>{{$invoice->getVehicle->vr_chassis_no ?? '' }}  <br>
                                                        <strong>Engine No. </strong>{{$invoice->getVehicle->vr_engine_no ?? '' }}  <br>
                                                        <strong>Engine Capacity </strong>{{$invoice->getVehicle->vr_engine_capacity ?? '' }}  <br>
                                                        <strong>Plate No. </strong>{{$invoice->getVehicle->vr_plate_no ?? '' }}  <br>

                                                    </address>
                                                    <address>
                                                        <strong> Date:</strong><br>
                                                        {{date('d M, Y', strtotime($invoice->getVehicle->vr_date))}}<br>
                                                        <strong>Invoice No.</strong> <br>
                                                        MVA/{{ date("M", strtotime($invoice->created_at)) }}/{{ date("Y", strtotime($invoice->created_at)) }}/{{ $invoice->id }}<br>
                                                    </address>
                                                </div>
                                                <div class="col-sm-6 text-sm-end">
                                                    <address class="mt-2 mt-sm-0">
                                                        <strong>Owner Details:</strong><br>
                                                        <strong>Name: </strong> {{$invoice->getVehicle->vr_new_owner_name ?? '' }} <br>
                                                        <strong>Email: </strong> {{$invoice->getVehicle->vr_new_owner_email ?? '' }} <br>
                                                        <strong>Mobile No: </strong> {{$invoice->getVehicle->vr_new_owner_mobile_no ?? '' }} <br>
                                                        <strong>Address: </strong> {{$invoice->getVehicle->vr_new_owner_address ?? '' }} <br>
                                                        <strong>NIN: </strong> {{$invoice->getVehicle->vr_new_owner_nin ?? '' }} <br>
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="py-2 mt-1">
                                                <h3 class="font-size-15 fw-bold">Products</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 70px;">#.</th>
                                                        <th>Product Category</th>
                                                        <th>Product</th>
                                                        <th>Cost({{env("APP_CURRENCY")}})</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($invoice->getInvoiceDetails as $key => $item )
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $item->getProductCategory->name ?? '-' }}</td>
                                                            <td>{{ $item->getProduct->product_name ?? '-' }}</td>
                                                            <td>{{ number_format($item->cost,2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="3" style="text-align: right;"><strong>Total: </strong></td>
                                                        <td> {{ number_format($invoice->getInvoiceDetails->sum('cost'),2) }}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>How to pay</h4>
                                                    <p>Visit any of our authorized banks for payment or use the online payment method. If you're using bank deposit, make use of the invoice number for payment in addition to our bank details.</p>
                                                </div>
                                            </div>

                                            <div class="d-print-none">
                                                <div class="float-end">
                                                    @if($invoice->status == 1)
                                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i> Print</a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('extra-scripts')

@endsection
