@extends('layouts.app')

@section('content')
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <!-- ... Other wrapper elements ... -->
    <div id="kt_app_content" class="app-content flex-column-fluid pb-0">
        <div id="kt_app_content_container" class="app-container container-xxl py-8 h-100 mt-16 mt-sm-0 mb-10 mb-sm-0">
            <div class="card h-100 " id="kt_edit_supplier_view">
                <div class="card-header">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Edit Category</h3>
                    </div>
                </div>
                <div id="kt_account_settings_edit_supplier" class="collapse show h-100">
                    <!-- Supplier Edit Form -->
                    <form id="kt_account_edit_supplier_form" class="form d-flex flex-column h-100 form fv-plugins-bootstrap5 fv-plugins-framework" method="post" action="{{ route('category.update', ['id' => $category->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="card-body border-top p-9 flex-1">
                            <!-- Supplier Data Fields -->
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Category Name</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="text" name="category" class="form-control form-control-lg mb-lg-0" placeholder="Category Name" value="{{ old('category', $category->category) }}">
                                    <br>
                                    <span class="alert-danger"></span>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6 mb-7">Slug</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="text" name="slug" class="form-control form-control-lg mb-lg-0" placeholder="Slug" value="{{ old('slug', $category->slug) }}">
                                    <br>
                                    <span class="alert-danger"></span>
                                </div>
                            </div>

                        </div>
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

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
        const form = $('#kt_account_edit_supplier_form');
        const saveChangesBtn = $('#saveChangesBtn');

        form.submit(function(e) {
            e.preventDefault();
            $('.alert-danger').hide();
            $('#kt_password_reset_submit').prop("disabled", true)
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
                    });

                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1500);
                },
                error: function(xhr) {
                    $('.indicator-label').show();
                    $('#kt_password_reset_submit').prop("disabled", false)
                    $('.indicator-progress').hide();
                    console.log("krishna", xhr)
                    if (xhr.status === 422) {
                        // Validation failed, display errors
                        $.each(xhr.responseJSON.errors, function(fieldName, errors) {
                            // Update the form field with the first error message
                            form.find('[name="' + fieldName + '"]').siblings('.alert-danger').html(errors[0]).show();
                        });
                    } else if (xhr.status === 401) {
                        // Unauthorized, credentials do not match
                        const errorMessage = xhr.responseJSON.message;
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

                        // Display a common error toast
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage,
                        });
                    } else {
                        const errorMessage = xhr.responseJSON.message;

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
