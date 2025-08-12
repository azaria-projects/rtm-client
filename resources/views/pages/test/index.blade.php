@extends('layouts.app')

@include('pages.test.scripts')

@section('content')

<div class="app-content-header">
    <div class="container-fluid container-column gap-4">
        <div class="d-flex flex-column">
            @include('pages.rtm.components.menu-selection')
        
            <div class="tab-content" id="tab-content"> 
                <div class="tab-pane fade show active" id="data-monitoring" role="tabpanel" aria-labelledby="tab-monitoring">
                    @include('pages.rtm.components.header')

                    <div class="d-flex flex-column">
                        <div class="mb-4">
                            @include('pages.rtm.components.main-charts')
                        </div>

                        <div class="mb-4">
                            @include('pages.rtm.components.table')
                        </div>

                        <div class="mb-4">
                            @include('pages.rtm.components.prediction-charts')
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade d-none" id="data-histories" role="tabpanel" aria-labelledby="tab-histories"></div>
            </div>
        </div>
    </div>
</div>

@include('pages.rtm.components.prediction-notif')

<div id="reset-click" class="d-none"></div>

@endsection
