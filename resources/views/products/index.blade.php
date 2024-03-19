@extends('layouts.master-layout')
@section('current-page')
    Manage Products
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('settings.partial._sidebar-menu')
            </div>
            <div class="col-xl-9 col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewProduct" class="btn btn-primary  mb-3">Add Product <i class="bx bxs-cart"></i> </a>

                    </div>
                    <div class="card-body">

                        <h4 class="card-title">All Products</h4>
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
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Products</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 col-lx-12">
                                        <div class="table-responsive mt-3">
                                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th class="">#</th>
                                                    <th class="wd-15p">Category</th>
                                                    <th class="wd-15p">Items</th>
                                                    <th class="wd-15p">Rates({{env('APP_CURRENCY')}})</th>
                                                    <th class="wd-15p">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $index = 1; @endphp
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{$index++}}</td>
                                                        <td>{{$product->getCategory->name ?? '' }}</td>
                                                        <td>{{$product->product_name ?? '' }}</td>
                                                        <td style="text-align: right">{{ number_format($product->cost ?? 0,2) }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#editProduct_{{$product->id}}" data-bs-toggle="modal"> <i class="bx bxs-pencil text-warning"></i> Edit</a>
                                                                </div>
                                                            </div>
                                                            <div class="modal right fade" id="editProduct_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" >
                                                                            <h4 class="modal-title" id="myModalLabel2">Edit Product</h4>
                                                                            <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <form autocomplete="off" action="{{route('edit-product')}}" data-parsley-validate="" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <div class="form-group mt-3">
                                                                                    <label for="">Product Category</label>
                                                                                    <select name="productCategory" data-parsley-required-message="Select product category" required class="form-control">
                                                                                        @foreach($categories as $c)
                                                                                            <option value="{{$c->id}}" {{$c->id == $product->category_id ? 'selected' : '' }}>{{$c->name ?? '' }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group mt-3">
                                                                                    <label for="">Product Item <span class="text-danger">*</span></label>
                                                                                    <input type="text" data-parsley-required-message="Enter product name"  required name="productName" placeholder="Product Name" value="{{old('productName', $product->product_name)}}" class="form-control">
                                                                                    @error('productName') <i class="text-danger">{{$message}}</i>@enderror
                                                                                </div>
                                                                                <div class="form-group mt-3">
                                                                                    <label for="">Rates <span class="text-danger">*</span></label>
                                                                                    <input type="number" step="0.01" value="{{$product->cost ?? 0 }}" data-parsley-required-message="What's the rate?" required name="cost" placeholder="Rates" class="form-control">
                                                                                    @error('cost') <i class="text-danger">{{$message}}</i>@enderror
                                                                                </div>
                                                                                <div class="form-group d-flex justify-content-center mt-3">
                                                                                    <input type="hidden" name="productId" value="{{$product->id}}">
                                                                                    <div class="btn-group">
                                                                                        <button type="submit" class="btn btn-primary  waves-effect waves-light">Save changes <i class="bx bxs-right-arrow"></i> </button>
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
                </div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="addNewProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h4 class="modal-title" id="myModalLabel2">Add Product</h4>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{route('add-product')}}" id="addProductForm" data-parsley-validate="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-3">
                            <label for="">Product Category</label>
                            <select name="productCategory" data-parsley-required-message="Select product category" required class="form-control">
                                @foreach($categories as $c)
                                    <option value="{{$c->id}}">{{$c->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Product Item <span class="text-danger">*</span></label>
                            <input type="text" data-parsley-required-message="Enter product name" required name="productName" placeholder="Product Name" value="{{old('productName')}}" class="form-control">
                            @error('productName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Rates <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" data-parsley-required-message="What's the rate?" required name="cost" placeholder="Rate" class="form-control">
                            @error('cost') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Save Product <i class="bx bxs-right-arrow"></i> </button>
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
    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/js/parsley.js"></script>
@endsection
