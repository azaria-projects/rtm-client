@extends('layouts.app')

@include('pages.rtm.scripts-test')

@section('content')

@include('components.loading')

<div class="app-content-header">
    <div class="container-fluid container-column gap-4">
        <div class="d-flex flex-column">
            <div class="icon-singular-group mb-4" style="width: fit-content !important;" role="tablist">
                <div class="icon-filter pills active" id="tab-monitoring" data-bs-toggle="tab" data-bs-target="#data-monitoring" type="button" role="tab" aria-controls="data-monitoring" aria-selected="true">
                    <i class="ti ti-heart-rate-monitor" style="font-size: 1.3rem"></i>
                    <span id="monitoring" class="me-2">Monitoring</span>
                </div>
        
                <div class="icon-filter pills" id="tab-histories" data-bs-toggle="tab" data-bs-target="#data-histories" type="button" role="tab" aria-controls="data-histories" aria-selected="false">
                    <i class="ti ti-contract" style="font-size: 1.3rem"></i>
                    <span id="histories" class="me-2">Histories</span>
                </div>
            </div>
        
            <div class="tab-content" id="tab-content"> 
                <div class="tab-pane fade show active" id="data-monitoring" role="tabpanel" aria-labelledby="tab-monitoring">
                    @include('pages.rtm.monitoring-test')
                </div>
                <div class="tab-pane fade" id="data-histories" role="tabpanel" aria-labelledby="tab-histories">
                    @include('pages.rtm.history')
                </div>
            </div>
        </div>

    </div>
</div>

<div id="reset-click" class="d-none"></div>

@endsection
