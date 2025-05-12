@extends('layouts.auth.app')

@push('scripts-body')
    <script>
        const act = @json($act);
        const wll = @json($wll);
        const com = @json($comu);

        var selected;

        function init() {
            //-- jquery select2
            $('select[id=filter-well]').select2({
                placeholder: 'select well',
                allowClear: true,
                data: act,
            });

            $('select[id=filter-company]').select2({
                placeholder: 'select company',
                allowClear: true,
                data: com,
            });

            //-- jquery select2 listener
            $('#filter-company').on('change', function() {
                const sel = $(this).find(':selected').val();
                if (sel) {
                    $('select[id=filter-well]').empty().select2({
                        placeholder: 'select well',
                        allowClear: true,
                        data: act.filter(item => item.id === sel),
                    });
                    
                    $('select[id=filter-well]').val(sel).trigger('change');
                    $('button[id=btn-next]').attr('disabled', false);
                    $('div[id=tab-select-well]').attr('disabled', false);
                    return;
                }

                $('button[id=btn-next]').attr('disabled', true);
                $('div[id=tab-select-well]').attr('disabled', true);
            });

            $('#filter-well').on('change', function() {
                const sel = $(this).find(':selected').text();
                if (sel) {
                    selected = sel;
                    $('button[id=btn-submit]').attr('disabled', false);
                    return;
                }

                $('button[id=btn-submit]').attr('disabled', true);
            });

            //-- remove previous selects
            $('select[id=filter-company]').val(null).trigger('change');
            $('select[id=filter-well]').val(null).trigger('change');
        }

        document.addEventListener("DOMContentLoaded", function () {
            init();

            document.getElementById('btn-next').addEventListener("click", function(){ 
                document.getElementById("tab-select-well").click();
            });

            document.getElementById('form-select').addEventListener('submit', async function(e) {
                e.preventDefault(); 

                const data = wll.filter(wl => wl.well_name === selected);

                document.cookie      = `well=${encodeURIComponent(JSON.stringify(data))}; path=/`;
                window.location.href = "{{ route('rtm.index') }}";
                return;
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

    {{-- login card --}}
    <div class="card">
        <div class="card-body login-card-body">
            <div id="container-login-header" class="d-flex align-items-center gap-0 column-gap-3">
                <img src="{{ asset('icons/icon-white.svg') }}" alt="" width="40" height="40">
                <div class="container-column">
                    <p class="header mb-0">Welcome back, <span>admin</span>!</p>
                    <p class="subheader mb-0">Please select the data to be monitored</p>
                    
                </div>
            </div>

            <div class="row m-0 w-100">
                <div class="col-12 px-0" role="tablist">
                    <div class="icon-singular-group" role="presentation">
                        <div class="icon-filter pills active" id="tab-select-company" data-bs-toggle="tab" data-bs-target="#data-select-company" type="button" role="tab" aria-controls="data-select-company" aria-selected="true">
                            <i class="ti ti-circle-dashed-number-1" style="font-size: 1.3rem"></i>
                            <span id="select-company" class="">Select Company</span>
                        </div>

                        <div class="icon-filter pills" id="tab-select-well" data-bs-toggle="tab" data-bs-target="#data-select-well" type="button" role="tab" aria-controls="data-select-well" aria-selected="false">
                            <i class="ti ti-circle-dashed-number-2" style="font-size: 1.3rem"></i>
                            <span id="select-well" class="">Select Well</span>
                        </div>
                    </div>
                </div>
            </div>

            <form id="form-select" method="post">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="data-select-company" role="tabpanel" aria-labelledby="tab-select-company" style="color: white">
                        <div class="mb-3">
                            <label for="filter-company" class="form-label"><i class="ti ti-affiliate me-1"></i> Companies </label>
                            <select id="filter-company" class="form-select select2" aria-label="Default select example"></select>  
                        </div>

                        <div class="btn-group-horizontal gap-2 w-100 mt-3" role="group">
                            <button id="btn-next" type="button" class="btn btn-primary"> 
                                <span id="btn-text-1" class="ms-1"> NEXT </span>
                            </button>

                            <button id="btn-logout-1" type="button" class="btn btn-logout"> 
                                <span id="btn-icn-1" class=""><i class="ti ti-power"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="data-select-well" role="tabpanel" aria-labelledby="tab-select-well" style="color: white">
                        <div class="mb-3">
                            <label for="filter-well" class="form-label"><i class="ti ti-crane me-1"></i> Wells </label>
                            <select id="filter-well" class="form-select select2" aria-label="Default select example"></select>  
                        </div>

                        <div class="btn-group-horizontal gap-2 w-100 mt-3" role="group">
                            <button id="btn-submit" type="submit" class="btn btn-secondary"> 
                                <span id="btn-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                <span id="btn-text" class="btn-text ms-1"> MONITOR WELL </span>
                            </button>

                            <button id="btn-logout-2" type="button" class="btn btn-logout"> 
                                <span id="btn-icn-2" class=""><i class="ti ti-power"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
