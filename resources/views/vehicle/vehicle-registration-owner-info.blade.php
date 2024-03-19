@extends('layouts.master-layout')
@section('current-page')
    Owners Information
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

                        <h4 class="card-title">Owners Information</h4>
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
                                <form class="forms-sample" name="frmSave" method="post" action="{{ route("reg-owner-info") }}">
                                    @csrf
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="form-group mt-4">
                                                <label for="">Name <sup class="text-danger">*</sup> </label>
                                                <input type="text" name="ownersName" placeholder="Owner's Name" class="form-control">
                                                @error("ownersName") <i>{{ $message }}</i> @enderror
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="">Address <sup class="text-danger">*</sup> </label>
                                                <input type="text" name="ownersAddress" placeholder="Owner's Address" class="form-control">
                                                @error("ownersAddress") <i>{{ $message }}</i> @enderror
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="">Telephone <sup class="text-danger">*</sup> </label>
                                                <input type="text" name="ownersTelephone" placeholder="Owner's Telephone" class="form-control">
                                                @error("ownersTelephone") <i>{{ $message }}</i> @enderror
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="">Email <sup class="text-danger">*</sup> </label>
                                                <input type="text" name="ownersEmail" placeholder="Owner's Email" class="form-control">
                                                @error("ownersEmail") <i>{{ $message }}</i> @enderror
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="">NIN <sup class="text-danger">*</sup> </label>
                                                <input type="text" name="ownersNIN" placeholder="Owner's NIN" class="form-control">
                                                @error("ownersNIN") <i>{{ $message }}</i> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive" >
                                                <table class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="3">Vehicle Details</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="table-success">
                                                        <th scope="row">Station</th>
                                                        <td>{{ $record->getStation->name ?? '' }}</td>
                                                    </tr>

                                                    <tr class="table-info">
                                                        <th scope="row">MLO</th>
                                                        <td>{{ $record->getMlo->ms_first_name ?? ''  }} {{ $record->getMlo->ms_last_name ?? ''  }} {{ $record->getMlo->ms_other_names ?? ''  }}</td>
                                                    </tr>

                                                    <tr class="">
                                                        <th scope="row">Number Plate Type</th>
                                                        <td>{{$record->getPlateType->pt_name ?? '' }}</td>
                                                    </tr>
                                                     <tr class="">
                                                        <th scope="row">Plate Number</th>
                                                        <td>{{ $record->vr_plate_no ?? '' }}</td>
                                                    </tr>
                                                     <tr class="">
                                                        <th scope="row">Vehicle Make</th>
                                                        <td>{{$record->getVehicleBrand->name ?? '' }} - {{ $record->getVehicleModel->vm_name ?? ''  }} </td>
                                                    </tr>
                                                     <tr class="">
                                                        <th scope="row">Color</th>
                                                        <td>{{ $record->getVehicleColor->name ?? '' }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <th scope="row">Chassis No.</th>
                                                        <td>{{ $record->vr_chassis_no ?? '' }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <th scope="row">Engine No.</th>
                                                        <td>{{ $record->vr_engine_no ?? ''  }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <th scope="row">Engine Capacity</th>
                                                        <td>{{ $record->vr_engine_capacity ?? '' }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <th scope="row">Purpose</th>
                                                        <td>{{ $record->vr_purpose ?? '' }}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12 col-lg-12 d-flex justify-content-center">
                                            <input type="hidden" name="slug" value="{{ $record->vr_slug }}">
                                            <button type="submit" class="btn btn-primary  ">Save & Continue</button>
                                        </div>
                                    </div>
                                </form>
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
