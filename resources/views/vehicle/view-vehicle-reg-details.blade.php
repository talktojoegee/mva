@extends('layouts.master-layout')
@section('current-page')
    Vehicle Information
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
                        <div class="row mb-2">
                            <div class="col-md-12 d-flex justify-content-end ">
                                <button class="btn btn-primary btn-sm">Approve Reg. <i class="bx bx-check-circle"></i> </button>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-lg-6 col-md-6" >
                                <div class="modal-header">
                                    <h6 class="modal-title text-uppercase">Vehicle Details</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th scope="col">Brand</th>
                                            <td scope="col">{{ $record->getVehicleBrand->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Model</th>
                                            <td>{{ $record->getVehicleModel->vm_name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Engine No.</th>
                                            <td>{{ $record->vr_engine_no ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Engine Capacity</th>
                                            <td>{{ $record->vr_engine_capacity ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Chassis No.</th>
                                            <td>{{ $record->vr_chassis_no ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Color</th>
                                            <td>{{ $record->getVehicleColor->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Plate Type</th>
                                            <td>{{ $record->getPlateType->pt_name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Plate No.</th>
                                            <td>{{ $record->vr_plate_no ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"> Date Registered</th>
                                            <td>{{ date("d M, Y", strtotime($record->vr_date)) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6" >
                                <div class="modal-header">
                                    <h6 class="modal-title text-uppercase">Owner Info</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <td scope="col">{{ $record->vr_new_owner_name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Email</th>
                                            <td>{{ $record->vr_new_owner_email ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Mobile No.</th>
                                            <td>{{ $record->vr_new_owner_mobile_no ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">NIN</th>
                                            <td>{{ $record->vr_new_owner_nin ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td>{{ $record->vr_new_owner_address ?? '' }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6 col-md-6" >
                                <div class="modal-header">
                                    <h6 class="modal-title text-uppercase">Other Details</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th scope="row">Status</th>
                                            <td>
                                                @switch($record->vr_status)
                                                    @case(0)
                                                    <span class="badge badge-soft-warning">Pending</span>
                                                    @break
                                                    @case(1)
                                                    <span class="badge badge-soft-success">Approved</span>
                                                    @break
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Station</th>
                                            <td>{{ $record->getStation->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">MLO</th>
                                            <td>{{ $record->getMlo->ms_first_name ?? '' }} {{ $record->getMlo->ms_last_name ?? '' }} {{ $record->getMlo->ms_other_names ?? '' }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6" >
                                <div class="modal-header">
                                    <h6 class="modal-title text-uppercase">Documents</h6>
                                </div>
                                <div class="table-responsive" bis_skin_checked="1">
                                    <table class="table table-nowrap align-middle table-hover mb-0">
                                        <tbody>
                                        @foreach($record->getVehicleRegDocuments as $doc)
                                            <tr>
                                                <td style="width: 45px;">
                                                    <div class="avatar-sm">
                                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                        <i class="bx bxs-file-doc"></i>
                                                    </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{$doc->getDocumentType->vrdt_name ?? '' }}</a></h5>
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <a href="{{ route("download-attachment", $doc->vrd_doc) }}" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
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

@endsection
