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
		<!--begin::Authentication - New password -->
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
					<div class="w-lg-500px p-10">
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="kt_new_password_form" method="POST" action="{{ route('password.update') }}">
							@csrf
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-gray-900 fw-bolder mb-3">Reset Password</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
									<a href="{{ route('login') }}" class="link-primary fw-bold">Sign in</a>
								</div>
								<!--end::Link-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->

							<div class="fv-row mb-8" data-kt-password-meter="true">
								<!--begin::Wrapper-->
								<div class="mb-1">
									<!--begin::Input wrapper-->
									<input class=" form-control" type="hidden" name="email" autocomplete="off" value="{{ $email }}" readonly />
									<div class="position-relative mb-3">
										<input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" autocomplete="off" />
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
											<i class="ki-duotone ki-eye-slash fs-2"></i>
											<i class="ki-duotone ki-eye fs-2 d-none"></i>
										</span>

										<span class="text-danger"></span>
									</div>
									<!--end::Input wrapper-->
								</div>
							</div>
							<!--end::Input group=-->
							<!--end::Input group=-->
							<div class="fv-row mb-8">
								<!--begin::Repeat Password-->
								<input type="password" placeholder="Repeat Password" name="password_confirmation" autocomplete="off" class="form-control bg-transparent @error('password_confirmation') is-invalid @enderror" />

								<span class="text-danger"></span>
								<!--end::Repeat Password-->
							</div>
							<!--end::Input group=-->
							<!--begin::Action-->
							<div class="d-grid mb-10">
								<button type="submit" id="kt_new_password_submit" class="btn btn-primary">
									<!--begin::Indicator label-->
									<span class="indicator-label">Submit</span>
									<!--end::Indicator label-->
									<!--begin::Indicator progress-->
									<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									<!--end::Indicator progress-->
								</button>
							</div>
							<!--end::Action-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
			</div>
			<!--end::Body-->

		</div>
		<!--end::Authentication - New password-->
	</div>
	<!--end::Root-->
	<!--begin::Javascript-->
	<script>
		var hostUrl = "assets/";
	</script>
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
	<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
	<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
	<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			// Check if the user is logged in
			@if(Auth::check())
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

			// Display the error message
			Toast.fire({
				icon: 'error',
				title: 'User is already logged in',
			}).then(() => {
				// Redirect after the Swal timer has finished
				window.location.href = '{{ route("dashboard") }}';
			});
			@endif
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			const form = $('#kt_new_password_form');
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
						}).then(() => {
							window.location.href = response.redirect;
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
							console.log(xhr)
							// Unauthorized, credentials do not match
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

							// Display a common error toast
							Toast.fire({
								icon: 'error',
								title: errorMessage,
							}).then(() => {
								window.location.href = xhr.responseJSON.redirect;
							});
						} else {
							console.log("krishna", xhr)
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
