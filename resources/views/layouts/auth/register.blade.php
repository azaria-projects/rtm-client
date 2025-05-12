@extends('layouts.auth.app')

@push('scripts-body')
    <script>
        function getCurrentDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                month: 'long', 
                day: 'numeric', 
                year: 'numeric',
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: false 
            };

            const formatted = now.toLocaleDateString('en-US', options).replace(',', '');
            document.getElementById('date-time').textContent = formatted;
            setTimeout(getCurrentDateTime, 1000);
        }

        document.addEventListener("DOMContentLoaded", function () {
            getCurrentDateTime();

            document.getElementById('form-register').addEventListener('submit', async function(e) {
                e.preventDefault(); 

                const btn = document.getElementById('btn-submit');
                const txt = document.getElementById('btn-text');
                const spn = document.getElementById('btn-spinner');
                
                btn.disabled    = true;
                txt.textContent = 'Requesting Access . . .';
                spn.classList.remove('d-none');

                const pyd = document.getElementById('user-email').value;
                if (pyd === '') {
                    toastr.error('Missing Credentials!');
                    spn.classList.add('d-none');
                    btn.disabled = false;
                    return;
                }

                const url = `${baseurl}/api/request/${pyd}`;
                const res = await post(url, pyd).then(data => data).catch(error => error);

                if (res.status) {
                    const mes = '<h6 class="mb-0"><b>Successfully requested an access!</b></h6>';
                    const sml = 'an admin will grant you an access and will send you email with your access.' + 
                                ' <b>GRANT PROCESS MIGHT TAKE SAVERAL DAYS.</b>' + 
                                ' you can leave this page and return once the access is given.';

                    txt.textContent = 'Access Requested! Please wait for a grant!';
                    spn.classList.add('d-none');
                    toastr.success(`${mes}<br><small>${sml}</small>`, null, { timeOut: 0, html: true });
                    return;
                }

                txt.textContent = 'Access Requested!';
                spn.classList.add('d-none');
                btn.disabled    = false;

                toastr.info('Did you requested an access already?');
            })
        })
    </script>
@endpush

@section('content')

<div class="login-box">
    {{-- logo --}}
    <div class="login-logo my-0">
        <a href="{{ route('login') }}"></a>
    </div>

    {{-- register card --}}
    <div class="card">
        <div class="card-body login-card-body">
            <div id="container-login-header" class="d-flex align-items-center gap-0 column-gap-3">
                <img src="{{ asset('icons/icon-white.svg') }}" alt="" width="40" height="40">
                <div class="container-column">
                    <p class="header mb-0">Request Access</p>
                    <p class="subheader mb-0">Realtime Monitoring Drilling System</p>
                    
                </div>
            </div>

            <div class="row m-0 w-100">
                <div class="col-12 px-0">
                    <div class="icon-singular-group">
                        <div class="only-icon-filter">
                            <i class="ti ti-calendar-clock"></i>
                            <span id="date-time" class="datetime"></span>
                        </div>
                    </div>
                </div>
            </div>

            <form id="form-register" method="post">
                <div class="mb-3">
                    <label for="user-email" class="form-label"><i class="bi bi-envelope-at-fill me-1"></i> Email address</label>
                    <input type="email" class="form-control" id="user-email" name="email" aria-describedby="emailHelp" placeholder="Email">
                </div>

                <div class="btn-group-vertical gap-2 w-100 mt-4" role="group">
                    <button id="btn-submit" type="submit" class="btn btn-primary"> 
                        <span id="btn-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        <span id="btn-text" class="btn-text ms-1"> Request </span>
                    </button>
                </div>

                <div class="d-flex my-2">
                    <small class="small-desc">Already requested an access? <a href="{{ route('login') }}" class="highlighted">click here to login</a> instead</small>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
