@extends('layouts.master-layout')
@section('title')
{{$type ?? '' }} Details
@endsection
@section('current-page')
{{$type ?? '' }} Details
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row profile-body">
            <div class="col-md-9 col-xl-9">
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

                <div class="col-md-12 col-xl-12 middle-wrapper">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="card">
                                <div class="card-body border-bottom">
                                    <div class="d-flex">
                                        <img src="{{asset('assets/images/'.Auth::user()->getUserOrganization->logo)}}" alt="" height="50">
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fw-semibold">{{Auth::user()->getUserOrganization->organization_name ?? ''  }}</h5>
                                            <ul class="list-unstyled hstack gap-2 mb-0">
                                                <li>
                                                    <i class="bx bx-message"></i> <span class="text-muted">{{Auth::user()->getUserOrganization->email ?? ''  }}</span>
                                                </li>
                                                <li>
                                                    <i class="bx bx-phone-call"></i> <span class="text-muted">{{Auth::user()->getUserOrganization->phone_no ?? ''  }}</span>
                                                </li>
                                                <li>
                                                    <i class="bx bx-building-house"></i> <span class="text-muted">{{Auth::user()->getUserOrganization->address ?? ''  }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th scope="col">To:</th>
                                                <td scope="col">
                                                    @if($scope == 4)
                                                        @foreach($users as $user)
                                                            {{$user->title ?? '' }} {{ $user->first_name ?? ''  }} {{ $user->last_name ?? '' }},
                                                        @endforeach
                                                    @elseif($scope == 2)
                                                        @foreach($branches as $branch)
                                                            {{$branch->cb_name ?? '' }}
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">From:</th>
                                                <td>{{$post->getAuthor->title ?? '' }} {{$post->getAuthor->first_name ?? '' }} {{$post->getAuthor->last_name ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Position:</th>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Date:</th>
                                                <td><span class="badge badge-soft-success">{{date('d M, Y h:i a', strtotime($post->created_at))}}</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h5 class="fw-semibold mb-3">Subject: {{ $post->p_title ?? ''  }}</h5>
                                    <p class="text-muted">We are looking to hire a skilled Magento developer to build and maintain eCommerce websites for our clients. As a Magento developer, you will be responsible for liaising with the design team, setting up Magento 1x and 2x sites, building modules and customizing extensions, testing the performance of each site, and maintaining security and feature updates after the installation is complete.</p>

                                    <h5 class="fw-semibold mb-3">Responsibilities:</h5>

                                    <h5 class="fw-semibold mb-3">Skill &amp; Experience:</h5>
                                    <ul class="vstack gap-3 mb-0">
                                        <li>
                                            Understanding of key Design Principal
                                        </li>
                                        <li>
                                            Proficiency With HTML, CSS, Bootstrap
                                        </li>
                                        <li>
                                            WordPress: 1 year (Required)
                                        </li>
                                        <li>
                                            Experience designing and developing responsive design websites
                                        </li>
                                        <li>
                                            web designing: 1 year (Preferred)
                                        </li>
                                    </ul>

                                    <div class="mt-4">
                                        <span class="badge badge-soft-warning">PHP</span>
                                        <span class="badge badge-soft-warning">Magento</span>
                                        <span class="badge badge-soft-warning">Marketing</span>
                                        <span class="badge badge-soft-warning">WordPress</span>
                                        <span class="badge badge-soft-warning">Bootstrap</span>
                                    </div>

                                    <div class="mt-4">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item mt-1">
                                                <a href="javascript:void(0)" class="btn btn-outline-danger btn-hover"><i class="uil uil-google"></i> Print </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <div class="d-none d-xl-block col-xl-3">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="card rounded">
                            <div class="">
                                <div class="modal-header">
                                    <h6 class="tx-11 fw-bolder text-uppercase">Recent Activities</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                    <div class="d-flex align-items-center hover-pointer">
                                        <img class="img-xs rounded-circle" src="../../../assets/images/faces/face2.jpg"
                                             alt="">
                                        <div class="ms-2">
                                            <p>Mike Popescu</p>
                                            <p class="tx-11 text-muted">12 Mutual Friends</p>
                                        </div>
                                    </div>
                                    <button class="btn btn-icon border-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-user-plus">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="20" y1="8" x2="20" y2="14"></line>
                                            <line x1="23" y1="11" x2="17" y2="11"></line>
                                        </svg>
                                    </button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-light border-0">View more</a>
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
