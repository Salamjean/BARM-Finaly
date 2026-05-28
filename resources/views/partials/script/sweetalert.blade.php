    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const ToastSuccess = Swal.mixin({
            toast: true,
            position: 'bottom-right',
            iconColor: 'white',
            color: 'white',
            background: '#15C162B6',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,

        })

        const ToastWarning = Swal.mixin({
            toast: true,
            position: 'bottom-right',
            iconColor: 'white',
            color: 'white',
            background: '#C1B615B6',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,

        })

        const ToastError = Swal.mixin({
            toast: true,
            position: 'bottom-right',
            iconColor: 'white',
            color: 'white',
            background: '#E864C5B0',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,

        })

        @if (session('success'))

            ToastSuccess.fire({
                text: "{{ session('success') }}",
                icon: "success",
            });
        @endif
        @if (session('warning'))

            ToastWarning.fire({
                text: "{{ session('warning') }}",
                icon: "warning",
            });
        @endif
        @if (session('error'))


            ToastError.fire({
                text: "{{ session('error') }}",
                icon: "error",
            });
        @endif
        @if ($errors->any())

            ToastError.fire({
                icon: 'error',
                title: "{{ $errors->first() }}",
            })
        @endif
    </script>
