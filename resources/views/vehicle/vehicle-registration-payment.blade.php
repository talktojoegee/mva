@extends('layouts.master-layout')
@section('current-page')
    Payment
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

                        <h4 class="card-title">Payment</h4>
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
                                <form class="forms-sample" name="frmSave" method="post" action="{{ route("generate-invoice") }}">
                                    @csrf
                                    <div class="row mt-4">
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
                                        <div class="col-md-6">
                                            <div class="form-group mt-4">
                                                <label for="">Issue Date<sup class="text-danger">*</sup> </label>
                                                <input type="date" name="issueDate" class="form-control">
                                                @error("issueDate") <i>{{ $message }}</i> @enderror
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="">Due Date<sup class="text-danger">*</sup> </label>
                                                <input type="date" name="dueDate" class="form-control">
                                                @error("dueDate") <i>{{ $message }}</i> @enderror
                                            </div>
                                            <div class="form-group mb-3 mt-3">
                                                <label for="">Choose Product(s)</label>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                @foreach($productCategories as $c)
                                                    <div class="modal-header" >
                                                        <h6 class="modal-title text-uppercase">{{ $c->name }}</h6>
                                                    </div>
                                                    @if(count($c->getProducts) <= 0)
                                                        <div class="d-flex justify-content-center p-1"> No product registered</div>
                                                    @else
                                                        <div class="row mt-2 pl-4">
                                                        @foreach($c->getProducts as $p)

                                                                <div class="col-md-6">
                                                                    <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                                        <input name="product[]" class="form-check-input productHandle" value="{{ $p->id }}" data-cost="{{$p->cost ?? 0 }}" type="radio">
                                                                        <input type="hidden" name="cost[]" value="{{ $p->cost }}">
                                                                        <input type="hidden" name="productCategory[]" value="{{ $c->id }}">

                                                                        <label class="form-check-label" >
                                                                            {{$p->product_name ?? ''}} - ({{ env("APP_CURRENCY") }}) {{ number_format($p->cost) ?? '' }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                        @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>


                                        </div>

                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12 col-lg-12 d-flex justify-content-center">
                                            <input type="hidden" name="slug" value="{{ $record->vr_slug }}">
                                            <input type="hidden" name="vehicleReg" value="{{ $record->vr_id }}">
                                            <button type="submit" class="btn btn-primary  ">Submit</button>
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
    <script src="/assets/js/axios.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#productCategory').on('change', function(){
                let selectedOption = $(this).val();
                const url = "{{route('get-products') }}";
                axios.post(url,{categoryId:selectedOption})
                    .then(res=> {
                        $("#tableBody").html(res.data);
                    });
            });

            /*$('.productHandle').on('click', function(){

            });*/

        });
    </script>
@endsection
