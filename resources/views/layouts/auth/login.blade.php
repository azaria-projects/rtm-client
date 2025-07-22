@extends('layouts.auth.app')

@push('scripts-body')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            getCurrentDateTime();
            
            const err = @json(session('error'));
            if (err) {
                toastr.error(err);
            }

            document.getElementById('form-login').addEventListener('submit', async function(e) {
                e.preventDefault(); 

                const btn = document.getElementById('btn-submit');
                const txt = document.getElementById('btn-text');
                const spn = document.getElementById('btn-spinner');
                
                btn.disabled    = true;
                txt.textContent = 'Logging in . . .';
                spn.classList.remove('d-none');

                const url = `${baseurl}/api/token`;
                const pyd = getPayload(e.target.elements);
                const res = await post(url, pyd).then(data => data).catch(error => error);

                if (res.status) {
                    document.cookie = `token=${JSON.stringify(res.response)}; path=/`;
                    window.location.href = "{{ route('rtm.select') }}";
                    return;
                }

                txt.textContent = 'Login';
                spn.classList.add('d-none');
                btn.disabled    = false;

                toastr.error('Your credentials does not match!');
            });
        })
    </script>
@endpush

@section('content')

<div class="login-box">
    {{-- logo --}}
    <div class="login-logo my-0">
        <a href="{{ route('login') }}"></a>
    </div>

    {{-- login card --}}
    <div class="card">
        <div class="card-body login-card-body">
            <div id="container-login-header" class="d-flex align-items-center gap-0 column-gap-3">
                <img src="{{ asset('icons/icon-white.svg') }}" alt="" width="40" height="40">
                <div class="container-column">
                    <p class="header mb-0">System Login</p>
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

            <form id="form-login" method="post">
                <div class="mb-3">
                    <label for="user-email" class="form-label"><i class="bi bi-envelope-at-fill me-1"></i> Email address</label>
                    <input type="email" class="form-control" id="user-email" name="email" placeholder="Email">
                </div>

                <div class="mb-3">
                    <label for="user-password" class="form-label"><i class="bi bi-person-fill-lock me-1"></i> Password</label>
                    <input type="password" class="form-control" id="user-password" name="password" placeholder="Password">
                </div>

                <div class="btn-group-vertical gap-2 w-100 mt-3 mb-2" role="group">
                    <button id="btn-submit" type="submit" class="btn btn-primary"> 
                        <span id="btn-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        <span id="btn-text" class="btn-text ms-1"> Login </span>
                    </button>
                </div>

                <div class="btn-group-vertical gap-2 w-100" role="group">
                    <button id="btn-test" type="button" class="btn btn-tetiary"> 
                        <a id="btn-text" href="{{ route('rtm.test') }}" class="btn-text ms-1" style="color: white;"> View Demo Instead ? </a>
                    </button>

                </div>

                <div class="d-flex my-2">
                    <small class="small-desc">Doesn’t have account? <a href="{{ route('register') }}" class="highlighted">request for an access</a> instead</small>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
