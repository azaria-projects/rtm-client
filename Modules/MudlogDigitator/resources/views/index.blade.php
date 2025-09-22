@extends('mudlogdigitator::layouts.app')

@include('mudlogdigitator::styles.index')

@include('mudlogdigitator::scripts')

@section('content')
    <div class="d-flex justify-content-center w-100 mb-2">
        @include('mudlogdigitator::components.menu-selection')
    </div>

    <div class="tab-content h-100" id="tab-content"> 
        <div class="tab-pane fade show active h-100" id="data-detection" role="tabpanel" aria-labelledby="tab-detection">
            @include('mudlogdigitator::components.menu-detection')
        </div>

        <div class="tab-pane fade h-100" id="data-merge" role="tabpanel" aria-labelledby="tab-merge">
            @include('mudlogdigitator::components.menu-merge')
        </div>

        <div class="tab-pane fade h-100" id="data-crop" role="tabpanel" aria-labelledby="tab-crop">
            @include('mudlogdigitator::components.menu-crop')
        </div>

        <div class="tab-pane fade h-100" id="data-rasterize" role="tabpanel" aria-labelledby="tab-rasterize">
            @include('mudlogdigitator::components.menu-rasterize')
        </div>
    </div>
@endsection