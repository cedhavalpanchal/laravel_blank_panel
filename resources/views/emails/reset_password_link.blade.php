<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <div class="bg-body d-flex flex-column-auto justify-content-cenrer align-items-start gap-2 gap-lg-4 py-4 px-10 overflow-auto" id="kt_app_header_nav">
            </div>
            <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
                <!--begin::Email template-->
                <style>
                    html,
                    body {
                        padding: 0;
                        margin: 0;
                        font-family: Inter, Helvetica, "sans-serif";
                    }

                    a:hover {
                        color: #009ef7;
                    }
                </style>
                <div id="#kt_app_body_content" style="background-color:#D5D9E2; padding-top:20px; padding-bottom:20px; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; width:100%;">
                    <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                        <div style="text-align:center; margin:0 60px 34px 60px">
                                            <div style="margin-bottom: 10px">
                                            </div>
                                            <div style="margin-bottom: 15px">

                                                <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" />
                                            </div>
                                            <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                                <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">{{ $actionText }} Password</p>
                                                <p style="margin-bottom:2px; color:#7E8299">We received a request to {{ $actionText }} your password for your account.</p>
                                                <p style="margin-bottom:2px; color:#7E8299">Please follow the below steps to complete the process:</p>
                                                <br>
                                                <ol style="color:#5E6278; font-size: 13px; font-weight: 500; margin:0;padding-left: 15px; text-align:left">
                                                    <li style="margin-bottom: 10px;">Click on the following link to {{ $actionText }} your password.</li>
                                                    <li style="margin-bottom: 10px;">If you did not request this password {{ $actionText }}, please ignore this email. Your account remains secure, and no action is required.</li>
                                                    <li style="margin-bottom: 10px;">For security reasons, the link will expire after 24 hours, so please {{ $actionText }} your password promptly.</li>
                                                </ol>
                                            </div>
                                            <a href="{{ route('reset-password-form', ['token' => $token]) }}" target="_blank" style="background-color:#85b07f; border-radius:6px; display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif; text-decoration:none">{{ $actionText }} Password</a>

                                        </div>
                                    </td>
                                </tr>
                                <!-- ... (Replace this with your additional content) ... -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Email template-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Wrapper-->
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
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>