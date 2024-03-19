@extends('layouts.master-layout')
@section('current-page')

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
                                <div class="row" >
                                    <div class="col-sm-12 col-md-12" >
                                        <div class="auth-logo mb-4" >
                                            <img src="/assets/drive/logo/logo.png" alt="logo" class="auth-logo-dark" height="90">
                                            <img src="/assets/drive/logo/logo.png" alt="logo" class="auth-logo-light" height="90">
                                        </div>
                                        <h4 class="card-title">The H.0.S.,</h4>
                                        <h4>National Uniform Licensing Scheme (NULS),</h4>
                                        <h4>Ojudu-Lagos.</h4> <br> <br>
                                        <p>Sir,</p>
                                        <p style="color:#000"><b>REQUEST FOR THE PRINTING OF NEW NUMBER PLATE</b></p>
                                        <p style="color:#000">We wish to request for the printing of the under listed New Number Plates for Kogi State Internal Revenue Service, worth Twelve Million One Hundred Thousand Four Hundred and Eighty three Naira Seventy Five Kobo Only (N12, 100,483.75).</p>
                                        <p style="color:#000">Attached is the evidence of payments.</p>
                                    </div>
                                </div>
                                <table class="table table-bordered" width="100%">
                                    <tbody>
                                    <tr class="table-info">
                                        <td>Ref Code</td>
                                        <td>{{$stock->sr_batch_code ?? '' }}</td>
                                    </tr>
                                    </tbody>
                                    <tbody>
                                    <tr class="table-success">
                                        <td>Requisition Date</td>
                                        <td>{{ date("d M, Y", strtotime($stock->sr_request_date)) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 70px;">#.</th>
                                            <th>LGA Code</th>
                                            @foreach($plateTypes as $type)
                                                <th>{{ $type->pt_name ?? '' }}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($plateTypes as $pt)

                                        @endforeach
                                        @foreach($stockDetails as $key => $detail )
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $detail->lga_name ?? '-' }}</td>
                                                @foreach(\App\Models\StockRequestDetail::getSumByPlateType($detail->srd_stock_id, $detail->srd_lga_id) as $val)
                                                    <td>{{ $val->srd_quantity ?? 0 }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-print-none">
                                    <div class="float-end">
                                        @if($stock->sr_status == 1)
                                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i> Print Letter</a>
                                        @elseif($stock->sr_status == 0)
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

@endsection

@section('extra-scripts')

@endsection
