@extends('layouts.master-layout')
@section('current-page')
    Dispense to MLO
@endsection
@section('extra-styles')
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
            <div class="col-xl-6 col-md-12 offset-lg-3 offset-md-3">
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
                            <div class="col-lg-12 col-md-12" >
                                <div class="modal-header" >
                                    <h6 class="modal-title text-uppercase">Dispense to MLO</h6>
                                </div>
                                <form action="{{route('dispense-to-mlo')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3 mt-4">
                                        <label for="">Date</label>
                                        <input type="date" name="date" value="{{ date('Y-m-d')  }}"  class="form-control">
                                        @error('date') <i class="text-danger">{{$message}}</i>@enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">MLO</label> <br>
                                        <select name="mlo" class="form-control select2">
                                            <option disabled selected>-- Select MLO --</option>
                                            @foreach($mlos as $mlo)
                                                <option value="{{$mlo->ms_id}}">{{$mlo->getStation->name ?? ''}} ({{ $mlo->ms_first_name ?? '' }} {{ $mlo->ms_last_name ?? '' }} {{ $mlo->ms_other_names ?? '' }})</option>
                                            @endforeach
                                        </select>
                                        @error('mlo') <i class="text-danger">{{$message}}</i>@enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Select Plate Number</label>
                                        <select name="plateNumber[]" class="form-control select2 select2-multiple" multiple="multiple">
                                            <option disabled selected>-- Select Plate Number --</option>
                                            @foreach($pendingStocks as $stock)
                                                <option value="{{$stock->id}}">{{$stock->getLga->lga_name ?? ''}} - {{ $stock->plate_no ?? '' }} </option>
                                            @endforeach
                                        </select>
                                        @error('plateNumber') <i class="text-danger">{{$message}}</i>@enderror
                                    </div>
                                    <div class="form-group d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary">Add to Cart <i class="bx bxs-cart"></i> </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 col-lx-12">
                        <div class="modal-header" >
                            <h6 class="modal-title text-uppercase">Item Cart</h6>
                        </div>
                        <form action="{{ route('dispense-items-to-mlo') }}" method="post">
                            @csrf
                        <div class="table-responsive mt-3">
                            <table id="" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th class="">#</th>
                                    <th class="wd-15p">Ref. Code</th>
                                    <th class="wd-15p">LGA Code</th>
                                    <th class="wd-15p">Plate Type</th>
                                    <th class="wd-15p">Plate Number</th>
                                    <th class="wd-15p">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($cartStocks as $key=> $item )
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{$item->getOneStockReceiptById($item->stock_receipt_master)->ref_code ?? '' }}</td>
                                            <td>{{$item->getLGA->lga_name ?? ''}}</td>
                                            <td>{{$item->getPlateType->pt_name ?? ''}}</td>
                                            <td>{{ $item->plate_no ?? ''}}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" data-bs-target="#removeItem{{$item->id}}" data-bs-toggle="modal"> <i class=" bx bx-trash" style="color:#ff0000;"></i> </a>
                                                <div class="modal fade" id="removeItem{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" >
                                                                <h4 class="modal-title" id="myModalLabel2">Remove Item</h4>
                                                                <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <p>Are you sure you want to remove <code>{{$item->plate_no ?? '' }}</code> from cart?</p>
                                                                    <input type="hidden" name="itemId" value="{{$item->id}}">
                                                                </div>
                                                                <div class="form-group d-flex justify-content-center mt-3">
                                                                    <button type="submit" class="btn btn-primary">Yes <i class="bx bxs-right-arrow"></i> </button>
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
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group justify-content-center d-flex">
                                    <button type="submit" class="btn btn-primary">Dispense To MLO <i class="bx bx-check"></i></button>
                                </div>
                            </div>
                        </div>
                        </form>
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
