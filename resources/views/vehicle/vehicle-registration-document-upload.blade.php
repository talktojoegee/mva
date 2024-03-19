@extends('layouts.master-layout')
@section('current-page')
    Document Upload
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

                        <h4 class="card-title">Document Upload</h4>
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
                                <form class="forms-sample" enctype="multipart/form-data" name="frmSave" method="post" action="{{ route("submit-documents") }}">
                                    @csrf
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="mb-3 dynamicWrapper" id="dynamicWrapper" style="border-bottom: 1px solid #ccc;">
                                                <div style="border-bottom:1px solid #dcdcdc;">
                                                    <div class="form-group mt-4 col-md-6">
                                                        <label for="">Document Type <sup class="text-danger">*</sup> </label>
                                                        <select name="documentType[]"  class="form-control ">
                                                            @foreach($documentTypes as $type)
                                                                <option value="{{ $type->vrdt_id }}">{{ $type->vrdt_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("documentType") <i>{{ $message }}</i> @enderror
                                                    </div>
                                                    <div class="form-group mt-4 mb-3">
                                                        <label for="">Document <sup class="text-danger">*</sup> </label> <br>
                                                        <input type="file" name="document[]"  class="form-control-file">
                                                        @error("ownersAddress") <i>{{ $message }}</i> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-danger btn-sm addNewField">Add New File <i class="bx bx-plus-circle"></i> </button>
                                                </div>
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
    <script>
        $(document).ready(function() {
            let max_fields = 20;
            let wrapper = $(".dynamicWrapper");
            let add_button = $(".addNewField");

            let x = 1;
            $(add_button).click(function(e) {
                e.preventDefault();
                if (x < max_fields) {
                    x++;
                    $(wrapper).append(`<div class="dField" style="border-bottom:1px solid #dcdcdc;"><div class="form-group mt-4 col-md-6">
                    <label for="">Document Type <sup class="text-danger">*</sup> </label>
                    <select name="documentType[]"  class="form-control ">
                        @foreach($documentTypes as $type)
                        <option value="{{ $type->vrdt_id }}">{{ $type->vrdt_name }}</option>
                        @endforeach
                    </select>
                    @error("documentType") <i>{{ $message }}</i> @enderror
                </div>
                    <div class="form-group mt-4">
                        <label for="">Document <sup class="text-danger">*</sup> </label> <br>
                        <input type="file" name="document[]"  class="form-control-file">
                            @error("ownersAddress") <i>{{ $message }}</i> @enderror
                    </div>
                    <div class="row mt-3 mb-2">
                        <div class="col-md-12 d-flex justify-content-start">
                            <button type="button" class="btn btn-warning btn-sm removeFile">Remove File <i class="bx bx-minus-circle"></i> </button>
                        </div>
                    </div></div>`);
                } else {
                    alert('You Reached the limits')
                }
            });
            $(wrapper).on("click", ".removeFile", function(e) {
                e.preventDefault();
                $(this).closest('.dField').remove();
                x--;
            })
        });
    </script>
@endsection
