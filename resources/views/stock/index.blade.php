@extends('layouts.master-layout')
@section('current-page')
    Stock Requisition
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Stock Requisition</h4>
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-2"></i>
                                {!! session()->get('success') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-close me-2"></i>
                                {!! session()->get('error') !!}
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
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">New Request</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#manage" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Manage Request</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 col-lx-12">
                                        <form action="{{route('new-stock-request')}}" method="post" autocomplete="off">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-6 col-6">
                                                    <label for="">Request Date</label>
                                                    <input type="date" value="{{date('Y-m-d')}}" name="requestDate" placeholder="Request Date" class="form-control">
                                                    @error('requestDate') <i class="text-danger">{{$message}}</i>@enderror
                                                </div>
                                                <div class="form-group col-md-6 col-6">
                                                    <label for="">LGA Code</label>
                                                    <select name="lgaCode"  class="form-control select2">
                                                        <option disabled selected>-- Select LGA Code --</option>
                                                        @foreach($lgas as $lga)
                                                            <option value="{{$lga->lga_id}}">{{ $lga->lga_name ?? '' }} ({{$lga->lga_code ?? '' }})</option>
                                                        @endforeach
                                                    </select>
                                                    @error('lgaCode') <i class="text-danger">{{$message}}</i>@enderror
                                                </div>
                                                <div class="row mt-4">
                                                    @foreach($plateTypes as $plate)
                                                        <div class="form-group col-md-6 col-6 mt-2">
                                                            <label for="">{{ $plate->pt_name ?? '' }}</label>
                                                            <input type="hidden" name="plateType[]" value="{{ $plate->pt_id }}">
                                                            <input type="number"  value="0"  name="quantity[]" placeholder="Enter # of plates..." class="form-control">
                                                            @error('plateType') <i class="text-danger">{{$message}}</i>@enderror
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                            <div class="form-group d-flex justify-content-center mt-3">
                                                <button type="submit" class="btn btn-primary">Submit Request <i class="bx bxs-right-arrow"></i> </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="manage" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 col-lx-12">
                                        <div class="table-responsive mt-3">
                                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th class="">#</th>
                                                    <th class="wd-15p">Ref. Code</th>
                                                    <th class="wd-15p">Request Date</th>
                                                    <th class="wd-15p">Requested By</th>
                                                    <th class="wd-15p">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($stocks as $key => $stock)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $stock->sr_batch_code ?? '' }}</td>
                                                        <td>{{ date('d M, Y', strtotime($stock->sr_request_date)) }}</td>
                                                        <td>{{$stock->getRequestBy->first_name ?? ''}} {{$stock->getRequestBy->last_name ?? ''}}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="{{route("stock-details", $stock->sr_batch_code)}}" > <i class="bx bx-book-open text-warning"></i> View</a>
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
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 col-lx-12">
                            <div class="modal-header" >
                                <h6 class="modal-title text-uppercase">Request List</h6>
                            </div>
                            <form action="{{ route("submit-stock-requisition") }}" method="post">
                                @csrf
                                <div class="table-responsive mt-3">
                                    <table id="" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th class="">#</th>
                                            <th class="wd-15p">LGA Code</th>
                                            <th class="wd-15p">Plate Type</th>
                                            <th class="wd-15p">Number</th>
                                            <th class="wd-15p">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($requestList as $key => $list)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $list->getLGA->lga_name ?? '' }} ({{ $list->getLGA->lga_code ?? '' }})</td>
                                                <td>{{ $list->getPlateType->pt_name ?? '' }} </td>
                                                <td>{{ number_format($list->srd_quantity ?? 0) ?? '' }} </td>
                                                <td>
                                                    <a href="javascript:void(0);" data-bs-target="#removeItem{{$list->srd_id}}" data-bs-toggle="modal"> <i class=" bx bx-trash" style="color:#ff0000;"></i> </a>
                                                    <div class="modal fade" id="removeItem{{$list->srd_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" >
                                                                    <h4 class="modal-title" id="myModalLabel2">Remove From List</h4>
                                                                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <p>Are you sure you want to remove this from the list?</p>
                                                                    </div>
                                                                    <div class="form-group d-flex justify-content-center mt-3">
                                                                        <a href="{{ route("remove-item-from-list", $list->srd_id) }}" class="btn btn-primary">Yes, please <i class=" ml-3 bx bxs-check-circle"></i> </a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button class="btn btn-primary" type="submit">Submit Request</button>
                                    </div>
                                </div>
                            </form>

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
    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-advanced.init.js"></script>
@endsection
