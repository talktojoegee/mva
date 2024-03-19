@extends('layouts.master-layout')
@section('current-page')
    Manage Users
@endsection
@section('extra-styles')

    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />


@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        @if(session()->has('success'))
            <div class="row" role="alert">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-all me-2"></i>
                        {!! session()->get('success') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="row" role="alert">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-all me-2"></i>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manage Users</h4>
                        <a href="{{route('add-new-pastor')}}"  class="btn btn-primary  mb-3">Add New User <i class="bx bxs-plus-circle"></i> </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lx-12">
                                <div class="table-responsive mt-3">
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th class="">#</th>
                                            <th class="wd-15p">Name</th>
                                            <th class="wd-15p">Phone Number</th>
                                            <th class="wd-15p">Email</th>
                                            <th class="wd-15p">Country</th>
                                            <th class="wd-5p">Status</th>
                                            <th class="wd-15p">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $index = 1; @endphp
                                        @foreach($users->where('is_admin',1) as $user)
                                            <tr>
                                                <td>{{$index++}}</td>
                                                <td>
                                                    <img src="{{url('storage/'.$user->image)}}" style="width: 24px; height: 24px;" alt="{{$user->first_name ?? '' }} {{$user->last_name ?? '' }}" class="rounded-circle avatar-sm">
                                                    <a href="{{route('user-profile', $user->slug)}}">{{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a> </td>
                                                <td>{{$user->cellphone_no ?? '' }} </td>
                                                <td>{{$user->email ?? '' }} </td>
                                                <td>{{$user->getUserCountry->name ?? '' }}</td>
                                                <td>
                                                    {!! $user->status == 1 ? "<i class='bx bxs-check-circle text-success'></i>" : "<i class='bx bxs-x-circle text-danger'></i>" !!}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{route('user-profile', $user->slug)}}"> <i class="bx bxs-user"></i> View Profile</a>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#deletePractitionerModal_{{$user->id}}" data-bs-toggle="modal"> <i class="bx bxs-trash text-danger"></i> Remove</a>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="deletePractitionerModal_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white" style="border-radius: 0px;">
                                                                    <button type="button"  class="btn-close text-white" style="margin: 0px; padding: 0px;" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    <h4 class="modal-title text-center text-white" id="myModalLabel2">Are you sure?</h4>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form autocomplete="off" action="{{route('delete-user')}}" method="post" id="addNewUser" data-parsley-validate="">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <p class="text-wrap">Are you sure you want to delete <strong class="text-danger">{{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</strong> from the system? This action cannot be undone.</p>
                                                                        </div>
                                                                        <div class="form-group mt-1">
                                                                            <input type="hidden" name="userId" value="{{$user->id}}"  class="form-control" >
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">No, cancel</button>
                                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Yes, proceed</button>
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

    <div class="modal right fade" id="client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" id="myModalLabel2">Add New Administrators</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{route('add-new-user')}}" method="post" id="addNewUser" data-parsley-validate="">
                        @csrf
                        <div class="form-group mt-1">
                            <label for="">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="firstName" data-parsley-required-message="What's the practitioner's first name?" placeholder="First Name" class="form-control" required="">
                            @error('firstName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lastName" required placeholder="Last Name" data-parsley-required-message="Not forgetting last name. What's the practitioner's last name?" class="form-control">
                            @error('lastName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for=""> Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobileNo" required placeholder="Mobile Phone Number" data-parsley-required-message="Enter phone number" class="form-control">
                            <input type="hidden" name="userType" value="1">
                            @error('mobileNo') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Email Address <span class="text-danger">*</span></label>
                            <input type="email" data-parsley-trigger="change" data-parsley-required-message="Enter a valid email address" required="" name="email" placeholder="Email Address" class="form-control">
                            @error('email') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Add New Administrator <i class="bx bxs-plus-circle"></i> </button>
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
        $(document).ready(function(){
            $('#addNewUser').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
                });
        });
    </script>
@endsection
