@push('scripts-body')
    <script src="{{ asset('themes/adminlte4/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('dependancies/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dependancies/moment/moment.min.js') }}"></script>
    <script src="{{ asset('dependancies/select2/js/select2.min.js') }}"></script>

    <script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/filepond@4.32.9/dist/filepond.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script> pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';</script>

    @vite([ 'resources/js/app.js' ])

    <script>
        pdfjsLib.SVGGraphics.prototype.paintInlineImageXObject = () => Promise.resolve();
        
        document.addEventListener('DOMContentLoaded', function() {
            const cover = document.getElementById('loading-cover');

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

            if (cover) { 
                cover.remove() 
            }
        });
    </script>
@endpush
