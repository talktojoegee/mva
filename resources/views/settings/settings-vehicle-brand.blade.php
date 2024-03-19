@extends('layouts.master-layout')
@section('current-page')
    Vehicle Brand
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
                        <div class="h6 text-left text-uppercase text-primary">Manage  Vehicle Brands</div>
                    </div>
                    <div class="container pb-5">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">Add  Vehicle Brand</div>
                                        <form action="{{route('add-product-category')}}" method="post" autocomplete="off">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Brand Name</label>
                                                <input disabled type="text" name="name" placeholder="Ex: GS Series" class="form-control">
                                                @error('name') <i class="text-danger">{{$message}}</i>@enderror
                                            </div>
                                            <div class="form-group d-flex justify-content-center mt-3">
                                                <button disabled type="submit" class="btn btn-primary">Submit <i class="bx bxs-right-arrow"></i> </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">  Vehicle Brands</h4>

                                        <div class="table-responsive">
                                            <table class="table mb-0" id="datatable">

                                                <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Brand</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $serial = 1; @endphp
                                                @foreach($brands as $cat)
                                                    <tr>
                                                        <th scope="row">{{$serial++}}</th>
                                                        <td>{{$cat->name ?? '' }}</td>
                                                        <td>
                                                            <a href="javascript:void(0);" data-bs-target="#editGroup_{{$cat->id}}" data-bs-toggle="modal"> <i class=" bx bx-pencil text-warning"></i> </a>
                                                            <div class="modal fade" id="editGroup_{{$cat->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" >
                                                                            <h4 class="modal-title" id="myModalLabel2">Edit Brand</h4>
                                                                            <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <form action="{{route('edit-product-category')}}" method="post" autocomplete="off">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <label for="">Brand Name</label>
                                                                                    <input disabled type="text" name="name" value="{{$cat->name ?? '' }}" placeholder="Ex: GS Series" class="form-control">
                                                                                    @error('name') <i class="text-danger">{{$message}}</i>@enderror
                                                                                    <input type="hidden" name="brandId" value="{{$cat->id}}">
                                                                                </div>
                                                                                <div class="form-group d-flex justify-content-center mt-3">
                                                                                    <button disabled type="submit" class="btn btn-primary">Save changes <i class="bx bxs-right-arrow"></i> </button>
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
