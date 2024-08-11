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
                                <h3 class="fw-bold m-0">Add Category</h3>
                            </div>
                        </div>
                        <div id="kt_account_settings_add_supplier" class="collapse show h-100">
                            <!--begin::Form-->
                            <form id="kt_account_add_supplier_form" class="d-flex flex-column h-100 form fv-plugins-bootstrap5 fv-plugins-framework" method="post" action="{{ route('category.store') }}">
                                @csrf
                                <!--begin::Card body-->
                                <div class="card-body border-top p-9 flex-1">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Category name</label>
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <input type="text" name="category" class="form-control form-control-lg mb-lg-0" placeholder="category name">

                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Slug</label>
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <input type="text" name="slug" class="form-control form-control-lg mb-lg-0" placeholder="Slug">

                                            <span class="text-danger"></span>
                                        </div>
                                    </div>

                                    {{-- <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Parent Category</label>
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <textarea name="description" class="form-control form-control-lg mb-lg-0" placeholder="Description"></textarea>

                                            <span class="text-danger"></span>
                                        </div>
                                    </div> --}}

                                </div>
                                <!--end::Card body-->
                                <!--begin::Actions-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <a href="{{ route('category.index') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancel</button></a>

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
                        timer: 2000,
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
                            timer: 2000,
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
                            timer: 2000,
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
