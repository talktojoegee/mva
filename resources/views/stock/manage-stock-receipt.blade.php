@extends('layouts.master-layout')
@section('current-page')
    Manage Stock Receipt
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Manage Stock Receipt</h4>
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
                        <div class="row">
                            <div class="col-md-12 col-lx-12">
                                <div class="table-responsive mt-3">
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th class="">#</th>
                                            <th class="wd-15p">Date</th>
                                            <th class="wd-15p">Received By</th>
                                            <th class="wd-15p">Ref. Code</th>
                                            <th class="wd-15p">Status</th>
                                            <th class="wd-15p">Quantity</th>
                                            <th class="wd-15p">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($stocks as $key => $stock)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ date('d M, Y', strtotime($stock->receipt_date)) }}</td>
                                                <td>{{$stock->getReceivedBy->first_name ?? ''}} {{$stock->getReceivedBy->last_name ?? ''}}</td>
                                                <td>{{$stock->ref_code ?? ''}}</td>
                                                <td>
                                                    @switch($stock->status)
                                                        @case(0)
                                                        <i class="text-warning">Pending</i>
                                                        @break
                                                        @case(1)
                                                        <i class="text-success">Approved</i>
                                                        @break
                                                        @case(2)
                                                        <i class="text-danger">Declined</i>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    {{ number_format($stock->getStockReceiptDetails->count()) }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route("stock-receipt-details", $stock->ref_code) }}" > <i class="bx bx-book-open text-warning"></i> View</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
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
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>
@endsection
