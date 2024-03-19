@extends('layouts.master-layout')
@section('current-page')
    Profile
@endsection
@section('extra-styles')
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="row mb-10" style="margin-bottom: 70px;">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="position-relative">
                    <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                        <img src="{{url('storage/covers/profile-cover.jpg')}}" class="rounded-top " alt="profile cover">
                    </figure>
                    <div class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                        <div>
                            <img class="wd-70 rounded-circle img-thumbnail avatar-xl" src="{{url('storage/'.$user->image)}}" alt="profile">
                            <span class="h4 ms-3 text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }}</span>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="btn-group">
                                <a href="" class="btn btn-primary btn-sm btn-icon-text">
                                    <i class="bx bx-user"></i> Edit profile
                                </a>
                                <a href="" class="btn btn-danger btn-sm btn-icon-text">
                                  <i class="bx bx-x-circle"></i>  Deactivate Account
                                </a>
                                <a href="javascript:void(0);" data-bs-target="#permissionModal" data-bs-toggle="modal" class="btn btn-secondary btn-sm btn-icon-text">
                                  <i class="bx bx-lock-alt"></i>  Access Level
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row profile-body">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
            <div class="card rounded">
                <div class="">
                    <div class="modal-header">
                        <h6 class="tx-11 fw-bolder text-uppercase">Personal Info</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Full Name</label>
                        <p class="text-muted">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }} {{$user->other_names ?? '' }}</p>
                    </div>
                    <div class=" mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Mobile No.</label>
                        <p class="text-muted">{{$user->cellphone_no ?? '' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email</label>
                        <p class="text-muted"><a href="mailto:{{$user->email ?? '#'}}">{{$user->email ?? '#'}}</a></p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Marital Status</label>
                        <p class="text-muted">{{$user->getUserMaritalStatus->ms_name ?? '' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Gender</label>
                        <p class="text-muted">{{$user->gender == 0 ? 'Female' : 'Male' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Birth Date</label>
                        <p class="text-muted">{{!is_null($user->birth_date) ? date('d M', strtotime($user->birth_date)) : '' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Nationality</label>
                        <p class="text-muted">{{$user->getUserCountry->name ?? '-'}}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">State</label>
                        <p class="text-muted">{{$user->getUserState->name ?? '-'}}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Occupation</label>
                        <p class="text-muted">{{$user->occupation ?? '-'}}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Address</label>
                        <p class="text-muted">{{$user->address_1 ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xl-9 middle-wrapper">
            <div class="col-md-12 grid-margin">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" >
                            <h6 class="modal-title text-uppercase" id="myModalLabel2">Access Level</h6>
                        </div>

                        <div class="modal-body">
                            <form autocomplete="off" autcomplete="off" action="{{route('add-permission')}}" method="post" id="addBranch" data-parsley-validate="">
                                @csrf
                                <div class="accordion-item mb-2">
                                    <div id="flush-collapse_" class="accordion-collapse collapse show" aria-labelledby="flush-heading_" data-bs-parent="#accordionFlushExample_" style="">
                                        <div class="accordion-body text-muted">
                                            <form action="">
                                                <div class="row">
                                                    @if(count($user->roles) > 0)
                                                        @foreach($user->roles->first()->permissions as $p)
                                                            <div class="col-md-3 col-lg-3">
                                                                <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                                    <input class="form-check-input" type="checkbox"  checked="">
                                                                    <label class="form-check-label" >
                                                                        {{$p->name ?? ''}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

    </div>
    <div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" id="myModalLabel2">Access Level</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" autcomplete="off" action="{{route('add-permission')}}" method="post" id="addBranch" data-parsley-validate="">
                        @csrf
                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header" id="flush-heading_">
                                    <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_" aria-expanded="false" aria-controls="flush-collapse_">
                                        {{$user->roles->first()->name ?? '' }}
                                    </button>
                                </h2>
                                <div id="flush-collapse_" class="accordion-collapse collapse show" aria-labelledby="flush-heading_" data-bs-parent="#accordionFlushExample_" style="">
                                    <div class="accordion-body text-muted">
                                        <form action="">
                                            <div class="row">
                                                @if(count($user->roles) > 0)
                                                @foreach($user->roles->first()->permissions as $p)
                                                    <div class="col-md-3 col-lg-3">
                                                        <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                            <input class="form-check-input" type="checkbox"  checked="">
                                                            <label class="form-check-label" >
                                                                {{$p->name ?? ''}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <hr>
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
            $('#clientAssignmentWrapper').hide();
            $("#clientAssignmentToggler").click(function(){
                $("#clientAssignmentWrapper").toggle();
            });
        });
    </script>
@endsection
