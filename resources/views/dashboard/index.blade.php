@extends('layouts.app')

@section('content')
@push('scripts')
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
        // Check if there is a message in localStorage
        var message = localStorage.getItem('message');
        if (message) {
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

            // Display the message
            Toast.fire({
                icon: message.includes('success') ? 'success' : 'error',
                title: message,
            });

            // Clear the message from localStorage
            localStorage.removeItem('message');
        }
    });
</script>
@endpush
@endsection
