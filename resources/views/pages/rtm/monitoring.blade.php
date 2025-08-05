<div class="row mb-4">
    <div class="col">
        <p class="page-header mb-0">REALTIME DASHBOARD</p>
        <p class="page-subheader mb-0">Monitor Realtime Well Data</p>
    </div>
</div>

<div class="row">
    <div class="col-2 h-100 d-none d-md-block pe-0">
        <div class="card h-100">
            <div class="card-header">
                <i class="ti ti-clock-24 me-1"></i>
                <div class="container-column">
                    <p class="card-subtitle">Data</p>
                    <p class="card-title">TIME</p>
                </div>
            </div>

            <div class="card-body h-100">
                <div class="chart-container" style="height: 450px;">
                    <canvas id="chart-time"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-10 h-100" style="overflow: scroll; height: 610px !important;">
        <div class="row row-gap-4">
            {{-- depth chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'depth',
                    'ccn' => 'depth',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-arrow-down-dashed',
                ])
            </div>

            {{-- bitdepth chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'bitdepth',
                    'ccn' => 'bitdepth',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-arrows-transfer-up-down',
                ])
            </div>

            {{-- bvdepth chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'bvdepth',
                    'ccn' => 'bvdepth',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-needle-thread',
                ])
            </div>

            {{-- bvdepth chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'block-pos',
                    'ccn' => 'blockpos',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-blocks',
                ])
            </div>

            {{-- torque chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'torque',
                    'ccn' => 'torque',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-whirl',
                ])
            </div>

            {{-- ropi chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'ropi',
                    'ccn' => 'ropi',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-arrow-big-down-lines',
                ])
            </div>

            {{-- wob chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'wob',
                    'ccn' => 'wob',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-stack-push',
                ])
            </div>

            {{-- stppress chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'stppress',
                    'ccn' => 'stppress',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-texture',
                ])
            </div>

            {{-- hkld chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'hkld',
                    'ccn' => 'hkld',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-fish-hook',
                ])
            </div>
            
            {{-- rpm chart --}}
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                @include('components.chart-graph', [
                    'cti' => 'rpm',
                    'ccn' => 'rpm',
                    'csb' => 'Sensor Data',
                    'clg' => 'ti-propeller',
                ])
            </div>
        </div>
    </div>
</div>