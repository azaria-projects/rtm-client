@push('scripts-body')
    @vite([
        'resources/js/app.js',
        'public/themes/adminlte4/js/adminlte.min.js',
        'public/dependancies/select2/js/select2.min.js',
    ])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-logout').forEach(button => {
                button.addEventListener('click', function() {
                    swal.fire(
                        getSwalConfPrompt('warning', 'LOGOUT ?', 'Logging out delete current session. Do you want to Logout?')
                    ).then((result) => {
                        if (result.value) {
                            resetCookies();
                            window.location.href = "{{ route('login') }}";
                            return;
                        }
                    });
                });
            });

            document.querySelectorAll('.btn-home').forEach(button => {
                button.addEventListener('click', function() {
                    swal.fire(
                        getSwalConfPrompt('question', 'CHANGE WELL ?', 'You will be redirected to selecting well page. Do you want to change well?')
                    ).then((result) => {
                        if (result.value) {
                            window.location.href = "{{ route('rtm.select') }}";
                            return;
                        }
                    });
                });
            });
        });
    </script>
@endpush
