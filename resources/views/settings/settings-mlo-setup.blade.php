@extends('layouts.master-layout')
@section('current-page')
    MLO Setup
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
                        <div class="h6 text-left text-uppercase text-primary">Manage  MLOs</div>
                        <button class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#addBranchModal"> <i class="bx bx-plus-circle"></i> Create New</button>
                    </div>
                    <div class="container pb-5">
                        <div class="table-responsive mt-3">
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th class="">#</th>
                                    <th class="wd-15p">MLO ID</th>
                                    <th class="wd-15p">Name</th>
                                    <th class="wd-15p">Email</th>
                                    <th class="wd-15p">Phone No.</th>
                                    <th class="wd-15p">Station</th>
                                    <th class="wd-15p">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($mlos as $key => $mlo)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $mlo->ms_mlo_id ?? '' }}</td>
                                            <td>{{ $mlo->ms_first_name ?? '' }} {{ $mlo->ms_last_name ?? '' }} {{ $mlo->ms_other_names ?? '' }}</td>
                                            <td>{{ $mlo->ms_email ?? '' }}</td>
                                            <td>{{ $mlo->ms_phone_no ?? '' }}</td>
                                            <td>{{ $mlo->getStation->name ?? '' }}</td>
                                            <td>
                                                <a href="javascript:void(0);" data-bs-target="#editGroup_{{$mlo->ms_id}}" data-bs-toggle="modal"> <i class=" bx bx-pencil text-warning"></i> </a>
                                                <div class="modal fade" id="editGroup_{{$mlo->ms_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" >
                                                                <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                <h4 class="modal-title" id="myModalLabel2">Edit MLO Setup</h4>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form action="{{route('edit-product-category')}}" method="post" autocomplete="off">
                                                                    @csrf
                                                                    <div class="form-group mt-3">
                                                                        <label for="">Station <span class="text-danger">*</span></label>
                                                                        <select name="station" id="station"  class="form-control">
                                                                            <option disabled selected>-- Select station --</option>
                                                                            @foreach($stations as $station)
                                                                                <option value="{{$station->id}}" {{ $station->id == $mlo->ms_station ? 'selected' : null }}>{{ $station->name ?? '' }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('station') <i class="text-danger">{{$message}}</i>@enderror
                                                                    </div>
                                                                    <div class="form-group mt-3">
                                                                        <label for=""> MLO ID <span class="text-danger">*</span></label>
                                                                        <input type="text" name="mloId" value="{{ $mlo->ms_mlo_id  ?? '' }}" required placeholder="MLO ID" data-parsley-required-message="Enter MLO ID" class="form-control">
                                                                        @error('mloId') <i class="text-danger">{{$message}}</i>@enderror
                                                                    </div>
                                                                    <div class="form-group mt-3">
                                                                        <label for=""> Last Name <span class="text-danger">*</span></label>
                                                                        <input type="text" name="lastName" value="{{ $mlo->ms_last_name  ?? '' }}" required placeholder="Last Name" data-parsley-required-message="Enter Last Name" class="form-control">
                                                                        @error('lastName') <i class="text-danger">{{$message}}</i>@enderror
                                                                    </div>
                                                                    <div class="form-group mt-3">
                                                                        <label for=""> First Name <span class="text-danger">*</span></label>
                                                                        <input type="text" name="firstName" value="{{ $mlo->ms_first_name  ?? '' }}" required placeholder="First Name" data-parsley-required-message="First Name" class="form-control">
                                                                        @error('firstName') <i class="text-danger">{{$message}}</i>@enderror
                                                                    </div>
                                                                    <div class="form-group mt-3">
                                                                        <label for=""> Other Names <small>(Optional)</small></label>
                                                                        <input type="text" name="otherNames" value="{{ $mlo->ms_other_names  ?? '' }}" placeholder="Other Names" data-parsley-required-message="Enter Other Names" class="form-control">
                                                                        @error('otherNames') <i class="text-danger">{{$message}}</i>@enderror
                                                                    </div>
                                                                    <div class="form-group mt-3">
                                                                        <label for=""> Phone Number <span class="text-danger">*</span></label>
                                                                        <input type="text" name="phoneNo" value="{{ $mlo->ms_phone_no  ?? '' }}" required placeholder="Phone Number" data-parsley-required-message="Enter Phone Number" class="form-control">
                                                                        @error('phoneNo') <i class="text-danger">{{$message}}</i>@enderror
                                                                    </div>
                                                                    <div class="form-group mt-3">
                                                                        <label for=""> Email Address <span class="text-danger">*</span></label>
                                                                        <input type="email" name="email" value="{{ $mlo->ms_email  ?? '' }}" required placeholder="Email Address" data-parsley-required-message="Enter Email Address" class="form-control">
                                                                        @error('email') <i class="text-danger">{{$message}}</i>@enderror
                                                                    </div>
                                                                    <div class="form-group d-flex justify-content-center mt-3">
                                                                        <input type="hidden" value="{{$mlo->ms_id}}" name="mloId">
                                                                        <button type="submit" class="btn btn-primary">Save changes <i class="bx bxs-right-arrow"></i> </button>
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
                    <h6 class="modal-title text-uppercase" id="myModalLabel2">Add New MLO Setup</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" autcomplete="off" action="{{route('add-mlo-setup')}}" method="post" id="addBranch" data-parsley-validate="">
                        @csrf

                        <div class="form-group mt-3">
                            <label for="">Station <span class="text-danger">*</span></label>
                            <select name="station" id="station"  class="form-control">
                                <option disabled selected>-- Select station --</option>
                                @foreach($stations as $station)
                                    <option value="{{$station->id}}">{{ $station->name ?? '' }}</option>
                                @endforeach
                            </select>
                            @error('station') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for=""> MLO ID <span class="text-danger">*</span></label>
                            <input type="text" name="mloId" required placeholder="MLO ID" data-parsley-required-message="Enter MLO ID" class="form-control">
                            @error('mloId') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="">User</label>
                            <select name="user" id="user"
                                    class="form-control">
                                <option selected disabled>-- Select --</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->first_name ?? '' }} {{ $user->last_name ?? '' }}</option>
                                @endforeach
                            </select>
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
    <script>

    </script>

@endsection
