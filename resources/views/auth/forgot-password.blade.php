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
	<link href="{{  asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{  asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{  asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
	<script>
		// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
	</script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank">
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<!--begin::Authentication - Password reset -->
		<div class="d-flex flex-column flex-lg-row flex-column-fluid">

			<!--begin::Aside-->
			<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center" style="background-image: url({{ asset('assets/media/misc/auth-bg.png') }})">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">

				</div>
				<!--end::Content-->
			</div>
			<!--end::Aside-->
			<!--begin::Body-->
			<div class="d-flex h-100 flex-column flex-lg-row-fluid w-lg-50 p-10 ">
				<!--begin::Form-->
				<div class="d-flex h-100 flex-center flex-column flex-lg-row-fluid">
					<!--begin::Wrapper-->
					<div class="min-w-400px max-w-100">

						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" method="POST" action="{{ route('password-reset-link') }}">
							@csrf
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-gray-900 fw-bolder mb-3">Forgot Password ?</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
								<!--end::Link-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group=-->
							<div class="fv-row mb-8">
								<!--begin::Email-->
								<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autofocus />


								<span class="text-danger"></span>
								<!--end::Email-->
							</div>
							<!--begin::Actions-->
							<div class="d-flex flex-wrap justify-content-center pb-lg-0">
								<a href="{{ route('login') }}" class="btn btn-light  me-4">Cancel</a>
								<button type="submit" id="kt_password_reset_submit" class="btn btn-primary ">
									<!--begin::Indicator label-->
									<span class="indicator-label">Submit</span>
									<!--begin::Indicator progress-->
									<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									<!--end::Indicator progress-->
									<!--end::Indicator label-->
								</button>

							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Body-->

		</div>
		<!--end::Authentication - Password reset-->
	</div>
	<!--end::Root-->
	<!--begin::Javascript-->
	<script>
		var hostUrl = "assets/";
	</script>
	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
	<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Custom Javascript(used for this page only)-->
	<script type="text/javascript">
		$(document).ready(function() {
			if ("{{Session::get('success')}}" != "" || '{{Session::get("error")}}' != "") {
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
				Toast.fire({
					icon: "{{Session::get('success')}}" ? 'success' : 'error',
					title: "{{Session::get('success')}}" ? "{{Session::get('success')}}" : "{{Session::get('error')}}",
				});

			}
		});
	</script>

	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			const form = $('#kt_password_reset_form');
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

					complete: function() {
						$('.indicator-label').show();
						$('#kt_password_reset_submit').prop("disabled", false)
						$('.indicator-progress').hide();
					},
					success: function(response) {
						form.trigger("reset");

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

						// Display success message
						Toast.fire({
							icon: 'success',
							title: response.success,
						});
					},
					error: function(xhr) {
						console.log("krishna", xhr);

						if (xhr.status === 422) {
							// Validation failed, display errors
							$.each(xhr.responseJSON.errors, function(fieldName, errors) {
								// Update the form field with the first error message
								form.find('[name="' + fieldName + '"]').siblings('.text-danger').html(errors[0]).show();
							});
						} else if (xhr.status === 401) {
							// Unauthorized, credentials do not match
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

							// Display a common error toast
							Toast.fire({
								icon: 'error',
								title: errorMessage,
							});
						} else {
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

</body>
<!--end::Body-->

</html>
