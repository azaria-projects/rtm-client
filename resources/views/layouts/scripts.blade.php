@push('scripts-body')
    <script src="{{ asset('themes/adminlte4/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('dependancies/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dependancies/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('dependancies/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('dependancies/moment/moment.min.js') }}"></script>
    <script src="{{ asset('dependancies/daterangepicker/js/daterangepicker.js') }}"></script>

    @vite([ 'resources/js/app.js' ])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cover = document.getElementById('loading-cover');
            const notif = document.getElementById('notification-sidebar');

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

            document.querySelectorAll('.btn-notification').forEach(button => {
                button.addEventListener('click', function() {
                    notif.classList.toggle('open');
                });
            });

            if (cover) { 
                cover.remove() 
            }
        });
    </script>
@endpush
