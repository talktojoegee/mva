@extends('layouts.master-layout')
@section('current-page')
    Stock Receipt
@endsection
@section('extra-styles')

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
                                    <h6 class="modal-title text-uppercase">Stock Receipt</h6>
                                </div>
                                <form action="{{route('upload-stock-receipt')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3 mt-4">
                                        <label for="">Receipt Date</label>
                                        <input type="date" name="receiptDate" value="{{ date('Y-m-d')  }}"  class="form-control">
                                        @error('receiptDate') <i class="text-danger">{{$message}}</i>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Upload File</label> <br>
                                        <input type="file" name="attachment" value="{{ date('Y-m-d')  }}"  class="form-control-file">
                                        @error('attachment') <i class="text-danger">{{$message}}</i>@enderror
                                    </div>
                                    <div class="form-group d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary">Upload Stock <i class="bx bxs-right-arrow"></i> </button>
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
