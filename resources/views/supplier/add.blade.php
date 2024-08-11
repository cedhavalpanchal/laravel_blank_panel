@extends('layouts.app')
@section('content')
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl py-8 h-100">
                    <div class="card h-100 mb-header-top-margin" id="kt_add_supplier_view">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Add Supplier</h3>
                            </div>
                        </div>
                        <div id="kt_account_settings_add_supplier" class="collapse show h-100">
                            <!--begin::Form-->
                            <form id="kt_account_add_supplier_form" class="d-flex flex-column h-100 form fv-plugins-bootstrap5 fv-plugins-framework" method="post" action="{{ route('supplier.store') }}">
                                @csrf
                                <!--begin::Card body-->
                                <div class="card-body border-top p-9 flex-1">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Supplier name</label>
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <input type="text" name="supplier_name" class="form-control form-control-lg mb-lg-0" placeholder="Supplier name">

                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Company name</label>
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <input type="text" name="company_name" class="form-control form-control-lg mb-lg-0" placeholder="Company name">

                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Email Address</label>
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <input type="text" name="email_address" class="form-control form-control-lg mb-lg-0" placeholder="Email Address">

                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Contact Number</label>
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <span class="mx-4 pt-4 fw-bold position-absolute note-span-supplier">+1</span>
                                            <input type="tel" name="contact_number" class="form-control form-control-lg mb-lg-0 ps-12" placeholder="Contact number" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                            <span class="text-danger"></span>
                                            <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10 fw-bold mb-8 bg-light p-3 rounded mt-2">
                                                <span>
                                                    <svg  width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#f1416c" d="M64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H288V352c0-17.7 14.3-32 32-32h80V96c0-8.8-7.2-16-16-16H64zM288 480H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H384c35.3 0 64 28.7 64 64V320v5.5c0 17-6.7 33.3-18.7 45.3l-90.5 90.5c-12 12-28.3 18.7-45.3 18.7H288z"/></svg>
                                                </span>
                                                <span class="ms-3 fs-6">Note: Please enter your phone number in the given format. <span class="note-span">+12485180302</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6 mb-7">Status</label>
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                <input id="statusCheckbox" class="form-check-input custom-status w-45px h-30px" type="checkbox" checked>
                                                <label class="form-check-label" for="statusCheckbox"></label>
                                                <!-- Hidden input field to store the actual status value -->
                                                <input type="hidden" name="status" id="statusInput" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card body-->
                                <!--begin::Actions-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <a href="{{ route('suppliers.index') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancel</button></a>

                                    <button type="submit" id="kt_password_reset_submit" class="btn btn-primary">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Save Changes</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>

                                <!--end::Actions-->
                                <input type="hidden">
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    // Add an event listener to update the hidden input value when the checkbox changes
    $('#statusCheckbox').change(function() {
        if (!this.checked) {
            $('#statusInput').val('0');
        } else {
            $('#statusInput').val('1');
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        const form = $('#kt_account_add_supplier_form');


        form.submit(function(e) {
            e.preventDefault();
            $('.text-danger').hide();
            $('#kt_password_reset_submit').prop("disabled", true)
            $('.indicator-label').hide();
            $('.indicator-progress').show();
            toastr.clear();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),

                success: function(response) {
                    // Hide loader on success
                    $('.indicator-label').show();
                    $('.indicator-progress').hide();
                    Swal.close();

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-start',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: response.success,
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                },
                error: function(xhr) {
                    $('.indicator-label').show();
                    $('#kt_password_reset_submit').prop("disabled", false)
                    $('.indicator-progress').hide();
                    Swal.close();

                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function(fieldName, errors) {
                            form.find('[name="' + fieldName + '"]').siblings('.text-danger').html(errors[0]).show();
                        });
                    } else if (xhr.status === 401) {
                        $('.indicator-label').show();
                        $('#kt_password_reset_submit').prop("disabled", false)
                        $('.indicator-progress').hide();
                        const errorMessage = xhr.responseJSON.error;
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

                        Toast.fire({
                            icon: 'error',
                            title: errorMessage,
                        });
                    } else {
                        $('.indicator-label').show();
                        $('#kt_password_reset_submit').prop("disabled", false)
                        $('.indicator-progress').hide();
                        // Handle other types of errors
                        const errorMessage = xhr.responseJSON.error || 'Something went wrong!';
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

@endpush
@endsection