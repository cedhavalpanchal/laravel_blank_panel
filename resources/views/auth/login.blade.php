<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Amazon Supplier Software</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center" style="background-image: url(assets/media/misc/auth-bg.png)">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                </div>
                <!--end::Content-->
            </div>
            <!--end::Aside-->
            <!--begin::Body-->
            <div class="d-flex h-100 flex-column flex-lg-row-fluid w-lg-50 p-10">
                <!--begin::Form-->
                <div class="d-flex h-100 flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="min-w-400px max-w-100">

                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="{{ route('login') }}">

                            @csrf
                            <!--begin::Logo-->

                            <!--end::Logo-->
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                                <!--end::Title-->
                            </div>
                            <!--begin::Input group=-->
                            <div class="fv-row mb-6">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Email-->


                                <div class="text-danger mt-1"></div>


                            </div>

                            <!--end::Input group=-->
                            <div class="fv-row mb-6">
                                <!--begin::Password-->
                                <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Password-->


                                <span class="text-danger"></span>


                            </div>
                            <!--end::Input group=-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <!--begin::Link-->
                                <a href="{{ route('password.forgot') }}" class="link-primary">Forgot Password ?</a>
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Sign In</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Body-->

        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <!-- ... Other HTML code ... -->

    <script type="text/javascript">
        $(document).ready(function() {
            const successMessage = "{{ Session::get('success') }}";
            const errorMessage = "{{ Session::get('error') }}";

            if (successMessage !== "") {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: successMessage,
                });
            }

            if (errorMessage !== "") {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'error',
                    title: errorMessage,
                });
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            const form = $('#kt_sign_in_form');
            form.submit(function(e) {
                e.preventDefault();

                const form = $(this);

                // Clear previous error messages and toasts
                $('.text-danger').hide();
                toastr.clear();

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        var role = response.role;

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

                        // Display a common success toast
                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        });

                        window.location.href = '{{ route("dashboard") }}';

                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation failed, display errors
                            $.each(xhr.responseJSON.errors, function(fieldName, errors) {
                                // Update the form field with the error message
                                form.find('[name="' + fieldName + '"]').siblings('.text-danger').html(errors[0]).show();
                            });
                        } else if (xhr.status === 401) {
                            // Unauthorized, credentials do not match
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
                                title: xhr.responseJSON.error,
                            });
                        } else {
                            console.log(xhr)
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

                            // Set a common error toast for other types of errors
                            Toast.fire({
                                icon: 'error',
                                title: xhr.responseJSON.error,
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>
<!--end::Body-->

</html>
