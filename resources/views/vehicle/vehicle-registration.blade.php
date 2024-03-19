@extends('layouts.master-layout')
@section('current-page')
    Vehicle Registration
@endsection
@section('extra-styles')
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

                        <h4 class="card-title">Vehicle Registration</h4>
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
                                <form class="forms-sample" name="frmSave" method="post" action="{{ route("vehicle-registration") }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-lx-6">
                                            <div class="form-group mb-3" >
                                                <label for="exampleInputName1">Date</label>
                                                <input type="date" value="{{ date('Y-m-d')  }}" class="form-control"  name="date" >
                                                @error("date") <i>{{$message}}</i>@enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="exampleInputName1">Vehicle Brand</label>
                                                <select class="form-control select2" name="vehicleBrand"  id="vehicleBrand">
                                                    <option selected disabled>--Select--</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}" >{{$brand->name ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                                @error("vehicleBrand") <i>{{$message}}</i>@enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="exampleInputName1">Vehicle Model</label>
                                                <div id="modelWrapper"></div>
                                                @error("vehicleModel") <i>{{$message}}</i>@enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="exampleInputName1">Vehicle Color</label>
                                                <select class="form-control select2" name="vehicleColor">
                                                    <option selected disabled>--Select--</option>
                                                    @foreach($colors as $color)
                                                        <option value="{{$color->id}}">{{$color->name ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                                @error("vehicleColor") <i>{{$message}}</i>@enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="exampleInputName1">Chassis No.</label>
                                                <input type="text" class="form-control" placeholder="Chassis Number" name="chassisNo" value="{{ old("chassisNo") }}">
                                                @error("chassisNo") <i>{{$message}}</i>@enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="exampleInputName1">Engine No.</label>
                                                <input type="text" class="form-control"  placeholder="Engine Number" name="engineNo" value="{{ old("engineNo") }}">
                                                @error("engineNo") <i>{{$message}}</i>@enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="exampleInputName1">Engine Capacity</label>
                                                <input type="number" class="form-control" id="Text1" placeholder="Engine Capacity" name="engineCapacity" value="{{ old("engineCapacity") }}">
                                                @error("engineCapacity") <i>{{$message}}</i>@enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="exampleInputName1">Purpose</label>
                                                <select class="form-control" name="slPurpose">
                                                    <option value="">--Select--</option>
                                                    <option value="1">Personal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lx-6">
                                            <h4 class="card-title">MLO Details</h4>
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr class="table-info">
                                                    <td><b>Station</b></td>
                                                    <td>{{ Auth::user()->getMloDetails->getStation->name ?? '' }}</td>
                                                </tr>
                                                </tbody>
                                                <tbody>
                                                <tr class="table-success">
                                                    <td><b>MLO</b></td>
                                                    <td>{{ Auth::user()->getMloDetails->ms_first_name ?? '' }} {{ Auth::user()->getMloDetails->ms_last_name ?? '' }} {{ Auth::user()->getMloDetails->ms_other_names ?? '' }}</td>
                                                </tr>
                                                </tbody>
                                                <tbody>
                                                <tr>
                                                    <td><b>Number Plate Type</b></td>
                                                    <td>
                                                        <select class="form-control" name="plateType" id="numberPlateType" >
                                                            <option value="">--Select--</option>
                                                            @foreach($plateTypes as $type)
                                                                <option value="{{ $type->pt_id }}">{{$type->pt_name ?? '' }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('plateType') <i>{{ $message }}</i> @enderror
                                                    </td>
                                                </tr>
                                                <tr id="numberPlateWrapper">
                                                    <td></td>
                                                    <td>plates</td>
                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 col-lg-12 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary  ">Next to Continue</button>
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
    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-advanced.init.js"></script>
    <script src="/assets/js/axios.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#numberPlateWrapper').hide();
            $('#vehicleBrand').on('change', function(){
                let selectedOption = $(this).val();
                const url = "{{route('get-vehicle-model') }}";
                axios.post(url,{brandId:selectedOption})
                    .then(res=> {
                        $("#modelWrapper").html(res.data);
                    });
            });

            $('#numberPlateType').on('change', function(){
                let selectedOption = $(this).val();
                const url = "{{route('get-number-plate-type') }}";
                axios.post(url,{plateId:selectedOption})
                    .then(res=> {
                        $("#numberPlateWrapper").show();
                        $("#numberPlateWrapper").html(res.data);
                    });
            });
        });
    </script>
@endsection
