<div class="card h-100">
    <div class="card-header">
        <i class="ti ti-calendar-clock me-1 d-none d-sm-block"></i>
        <div class="container-column">
            <p class="card-subtitle">Sensor data taken from API every 5s</p>
            <p class="card-title">TIME BASED DATA</p>
        </div>
    </div>

    <div class="card-body h-100">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                <div class="mb-2">
                    <label for="filter-range" class="form-label"><i class="ti ti-timeline-event-plus me-1"></i> Range Intervals </label>
                    <select id="filter-range" class="form-select select2" aria-label="filter-interval"></select>  
                    <small class="text-help">* adjust the amount of data displayed on the charts</small>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                <div class="mb-2">
                    <label for="filter-scales" class="form-label"><i class="ti ti-ruler-2 me-1"></i> Scale Intervals </label>
                    <select id="filter-scales" class="form-select select2" aria-label="filter-scale"></select>  
                    <small class="text-help">* adjust the data scale for each data point</small>
                </div>
            </div>

            <div class="col-12">
                <div class="btn-group-horizontal gap-2" role="group" style="width: fit-content;">
                    <button id="btn-filter" type="button" class="btn btn-primary d-flex align-items-center gap-2 mx-0 mt-2"> 
                        <i class="ti ti-brand-apple-arcade" style="font-size: 1.2rem;"></i>
                        Apply
                    </button>
                </div>
            </div>
        </div>

        <div class="d-flex flex-nowrap overflow-auto">
            <div class="icon-filter-group">
                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'Depth'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'Bitdepth'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'BVdepth'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'Block-Pos'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'Torque'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'ROPi'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'WOB'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'STPPRESS'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'HKLD'
                ])

                @include('components.btn-filter', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nb' => 'chart-filter-1',
                    'tt' => 'RPM'
                ])
            </div>
        </div>

        <div id="main-charts" class="row flex-nowrap overflow-auto m-0 p-0 w-100" style="height: 705px;">
            @foreach ($chr as $chartName)
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 m-0 p-0 h-100">
                    <div class="chart-container m-0 p-0" style="height: 700px;">
                        <canvas id="{{ 'chart-' . $chartName }}" class="m-0 p-0" style="border: 0;"></canvas>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>