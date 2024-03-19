@extends('layouts.master-layout')
@section('current-page')
    LGA Codes
@endsection
@section('extra-styles')
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    @if(session()->has('success'))
        <div class="row" role="alert">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i>

                    {!! session()->get('success') !!}

                    <button type="button"  class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="row" role="alert">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-outline me-2"></i>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-body" style="padding: 2px;">
            <div class="row">
                <div class="col-md-3">
                    @include('settings.partial._sidebar-menu')
                </div>
                <div class="col-md-9 mt-4">
                    <div class="d-flex justify-content-between">
                        <div class="h6 text-left text-uppercase text-primary">Manage LGAs</div>
                        <button class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#addBranchModal"> <i class="bx bx-plus-circle"></i> Add LGA Code</button>
                    </div>
                    <div class="container pb-5">
                        <div class="table-responsive mt-3">
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th class="">#</th>
                                    <th class="wd-15p">LGA Name</th>
                                    <th class="wd-15p">LGA Code</th>
                                    <th class="wd-15p">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lgas as $key=> $lga)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$lga->lga_name ?? '' }}</td>
                                        <td>{{$lga->lga_code ?? '' }}</td>
                                        <td>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#showMoreModal_{{$lga->lga_id}}" data-bs-toggle="modal"> <i class="bx bx-pencil text-warning"></i> </a>
                                            <div class="modal right fade" id="showMoreModal_{{$lga->lga_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white" style="border-radius: 0px;">
                                                            <h6 class="modal-title text-uppercase" id="myModalLabel2_{{$lga->lga_id}}">Edit LGA</h6>
                                                            <button type="button"  class="btn-close text-white" style="margin: 0px; padding: 0px;" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form autocomplete="off" autcomplete="off" action="{{route('edit-lga')}}" method="post" data-parsley-validate="">
                                                                @csrf
                                                                <div class="form-group mt-3">
                                                                    <label for="">LGA Name <span class="text-danger">*</span></label>
                                                                    <input type="text" value="{{$lga->lga_name ?? '' }}" name="lgaName" required placeholder="LGA Name" data-parsley-required-message="What will you call this LGA?" class="form-control">
                                                                    @error('lgaName') <i class="text-danger">{{$message}}</i>@enderror
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <label for=""> LGA Code <span class="text-danger">*</span></label>
                                                                    <input type="text" value="{{$lga->lga_code ?? '' }}" name="lgaCode" required placeholder="LGA Code" data-parsley-required-message="Enter LGA Code" class="form-control">
                                                                    @error('lgaCode') <i class="text-danger">{{$message}}</i>@enderror
                                                                </div>
                                                                <div class="form-group d-flex justify-content-center mt-3">
                                                                    <div class="btn-group">
                                                                        <input type="hidden" name="lgaId" value="{{$lga->lga_id}}">
                                                                        <button type="submit" class="btn btn-primary  waves-effect waves-light">Save changes <i class="bx bx-save"></i> </button>
                                                                    </div>
                                                                </div>
                                                            </form>

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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" id="myModalLabel2">Add New LGA Code</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" autcomplete="off" action="{{route('lgas-settings')}}" method="post" id="addBranch" data-parsley-validate="">
                        @csrf

                        <div class="form-group mt-3">
                            <label for="">LGA Name <span class="text-danger">*</span></label>
                            <input type="text" name="lgaName" required placeholder="LGA Name" data-parsley-required-message="What will you call this LGA?" class="form-control">
                            @error('lgaName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for=""> LGA Code <span class="text-danger">*</span></label>
                            <input type="text" name="lgaCode" required placeholder="LGA Code" data-parsley-required-message="Enter LGA Code" class="form-control">
                            @error('lgaCode') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Submit <i class="bx bxs-plus-circle"></i> </button>
                            </div>
                        </div>
                    </form>

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
    <script src="/assets/js/pages/datatables.init.js"></script>

@endsection
