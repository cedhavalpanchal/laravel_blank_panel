@extends('layouts.app')
@section('content')
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl py-8 h-100">
                    <div class="card h-100" id="kt_profile_details_view">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Profile Details</h3>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
                            <!--end::Action-->
                        </div>
                        <!--begin::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body p-9">
                            <!--begin::Row-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-auto fw-semibold text-muted min-w-150px">Full Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 col-xl-5 col-xxl-4">
                                    <span class="fw-bold fs-6 text-gray-800">{{ auth()->user()->name }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-auto fw-semibold text-muted min-w-150px">Email Id</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 col-xl-5 col-xxl-4 fv-row">
                                    <span class="fw-semibold text-gray-800 fs-6">{{ auth()->user()->email }}</span>
                                </div>

                                <!--end::Col-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
