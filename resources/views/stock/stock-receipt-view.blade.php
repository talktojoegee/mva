@extends('layouts.master-layout')
@section('current-page')
    Stock Receipt Details
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

                        <div class="row" >
                            <div class="col-lg-12" >
                                <div class="card" >
                                    <div class="card-body" >
                                        <div class="invoice-title" >
                                            <h4 class="float-end font-size-16">Ref. No. {{$stock->ref_code ?? '' }}</h4>
                                            <div class="auth-logo mb-4" >
                                                <img src="/assets/drive/logo/logo.png" alt="logo" class="auth-logo-dark" height="90">
                                                <img src="/assets/drive/logo/logo.png" alt="logo" class="auth-logo-light" height="90">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row" >
                                            <div class="col-sm-6" >
                                                <address>
                                                    <strong>Received By:</strong><br>
                                                    {{$stock->getReceivedBy->first_name ?? '' }} {{$stock->getReceivedBy->last_name ?? '' }}<br>
                                                    {{$stock->getReceivedBy->email ?? '' }}<br>
                                                    {{$stock->getReceivedBy->cellphone_no ?? '' }}<br>
                                                </address>
                                                <address>
                                                    <strong> Date Received:</strong><br>
                                                    {{date('d M, Y', strtotime($stock->receipt_date))}}<br> <br>
                                                </address>
                                            </div>
                                            <div class="col-sm-6 text-sm-end">
                                                <address class="mt-2 mt-sm-0">
                                                    <strong>Approved By:</strong><br>
                                                    {{$stock->getActionedBy->first_name ?? '' }} {{$stock->getActionedBy->last_name ?? '' }}<br>
                                                    {{$stock->getActionedBy->email ?? '' }}<br>
                                                    {{$stock->getActionedBy->cellphone_no ?? '' }}<br>
                                                </address>
                                                @if($stock->status == 1)
                                                <address>
                                                    <strong> Date Approved:</strong><br>
                                                    {{date('d M, Y', strtotime($stock->date_actioned))}}<br> <br>
                                                </address>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="py-2 mt-1">
                                            <h3 class="font-size-15 fw-bold">Receipt summary</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap">
                                                <thead>
                                                <tr>
                                                    <th style="width: 70px;">#.</th>
                                                    <th>Plate Type</th>
                                                    <th>LGA Code</th>
                                                    <th class="text-end">Plate No.</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($stock->getStockReceiptDetails as $key=> $item )
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{$item->getPlateType->pt_name ?? ''}}</td>
                                                        <td>{{ $item->lga_code ?? ''}}</td>
                                                        <td class="text-end">{{ $item->plate_no }}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                @if($stock->status == 1)
                                                    <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i> Print</a>
                                                @elseif(($stock->status == 0) )
                                                    <a href="javascript:void(0);" data-bs-target="#approvePrompt" data-bs-toggle="modal" class="btn btn-primary w-md waves-effect waves-light">Approve Request</a>
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
    <div class="modal fade" id="approvePrompt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h4 class="modal-title" id="myModalLabel2">Are you sure?</h4>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('approve-stock-receipt')}}" method="post" autocomplete="off">
                        @csrf
                        <p><strong class="text-danger">Note:</strong> This action cannot be undone. Are you sure you want to approve this request?</p>
                        <div class="form-group">
                            <input type="hidden" name="stockId" value="{{$stock->id}}">
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary">Approve Receipt <i class="bx bx-check"></i> </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-scripts')

@endsection
