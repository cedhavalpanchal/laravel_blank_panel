@extends('layouts.app')

@section('content')
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid">

                <div id="kt_app_content_container" class="app-container container-xxl py-8 h-100">
                    <div class="card h-100" id="kt_edit_general_settings_view">

                        <div class="card-header">
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Edit General Settings</h3>
                            </div>
                        </div>
                        <div id="kt_account_settings_edit_general_settings" class="collapse show h-100">

                            <form id="kt_account_edit_general_settings_form" class="form d-flex flex-column h-100 fv-plugins-bootstrap5 fv-plugins-framework" method="post" action="{{ route('settings.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="card-body border-top flex-1 p-9">
                                    <div class="row mb-6">
                                        <label class="col-lg-auto col-form-label required fw-semibold fs-6 min-w-150px">Client ID</label>
                                        <div class="col-lg-8 col-xl-5 col-xxl-4 fv-row fv-plugins-icon-container">
                                            <input type="text" name="sp_api_client_id" class="form-control form-control-lg mb-lg-0" placeholder="Client ID" value="{{ old('sp_api_client_id', $client_id) }}">

                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-auto col-form-label required fw-semibold fs-6 min-w-150px">Client Secret</label>
                                        <div class="col-lg-8 col-xl-5 col-xxl-4 fv-row fv-plugins-icon-container">
                                            <input type="text" name="sp_api_client_secret" class="form-control form-control-lg mb-lg-0" placeholder="Client Secret" value="{{ old('sp_api_client_secret', $client_secret) }}">

                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <a href="{{ route('shipments.index') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancel</button></a>

                                    <button type="submit" id="kt_general_settings_submit" class="btn btn-primary">

                                        <span class="indicator-label">Save Changes</span>


                                        <span class="indicator-progress">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>

                                    </button>
                                </div>

                                <input type="hidden">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        const form = $('#kt_account_edit_general_settings_form');

        form.submit(function(e) {
            e.preventDefault();
            $('.text-danger').hide();
            $('#kt_general_settings_submit').prop("disabled", true)
            $('.indicator-label').hide();
            $('.indicator-progress').show();
            toastr.clear();
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    $('.indicator-label').show();
                    $('.indicator-progress').hide();
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
                    $('.indicator-label').show();
                    $('#kt_general_settings_submit').prop("disabled", false)
                    $('.indicator-progress').hide();
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
@endpush