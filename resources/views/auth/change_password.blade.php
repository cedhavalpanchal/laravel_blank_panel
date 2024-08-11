@extends('layouts.app')

@section('content')
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl py-8 h-100">
                    <div class="card h-100" id="kt_change_password_view">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Change Password</h3>
                            </div>
                            <!--end::Action-->
                        </div>
                        <!--begin::Card header-->
                        <!--begin::Card body-->
                        <div id="kt_account_settings_change_password" class="collapse show h-100">
                            <!--begin::Form-->
                            <form id="kt_account_change_password_form" class="form d-flex flex-column h-100 fv-plugins-bootstrap5 fv-plugins-framework" method="post" action="{{ route('change-password.post') }}">
                                @csrf
                                <!--begin::Card body-->
                                <div class="card-body border-top p-9 flex-1">
                                    <!-- Password Change Fields -->
                                    <div class="row mb-6">
                                        <!-- Current Password -->
                                        <label class="col-lg-auto col-form-label required fw-semibold fs-6 min-w-150px col-form-label required fw-semibold">Current Password</label>
                                        <div class="col-lg-8 col-xl-5 col-xxl-4 fv-row fv-plugins-icon-container">
                                            <input type="password" name="current_password" class="form-control form-control-lg @error('current_password') is-invalid @enderror" placeholder="Current Password">
                                            <span class="text-danger mt-1"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <!-- New Password -->
                                        <label class="col-lg-auto col-form-label required fw-semibold fs-6 min-w-150px col-form-label required fw-semibold">New Password</label>
                                        <div class="col-lg-8 col-xl-5 col-xxl-4 fv-row fv-plugins-icon-container">
                                            <input type="password" name="new_password" class="form-control form-control-lg @error('new_password') is-invalid @enderror" placeholder="New Password">
                                            <span class="text-danger mt-1"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <!-- Confirm Password -->
                                        <label class="col-lg-auto col-form-label required fw-semibold fs-6 min-w-150px col-form-label required fw-semibold">Confirm Password</label>
                                        <div class="col-lg-8 col-xl-5 col-xxl-4 fv-row fv-plugins-icon-container">
                                            <input type="password" name="confirm_password" class="form-control form-control-lg @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password">
                                            <span class="text-danger mt-1"></span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card body-->
                                <!--begin::Actions-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('dashboard') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancel</button></a>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                                <!--end::Actions-->
                                <input type="hidden">
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        const form = $('#kt_account_change_password_form');
        form.submit(function(e) {
            e.preventDefault();
            $('.text-danger').hide();
            toastr.clear();
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-start',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    });

                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1500);
                },
                error: function(xhr) {
                    console.log("krishna", xhr)
                    if (xhr.status === 422) {
                        // Validation failed, display errors
                        $.each(xhr.responseJSON.errors, function(fieldName, errors) {
                            // Update the form field with the first error message
                            form.find('[name="' + fieldName + '"]').siblings('.text-danger').html(errors[0]).show();
                        });
                    } else if (xhr.status === 401) {
                        // Unauthorized, credentials do not match

                        const errorMessage = xhr.responseJSON.message;
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-start',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        // Display a common error toast
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage,
                        });
                    } else {
                        // Handle other types of errors

                        const errorMessage = xhr.responseJSON.message;

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-start',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });

                        // Set an error toast with the server-provided error message
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage,
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
