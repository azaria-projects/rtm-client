<div class="row mb-4">
    <div class="col">
        <p class="page-header mb-0">REALTIME DASHBOARD</p>
        <p class="page-subheader mb-0">Monitor Realtime Well Data</p>
    </div>
</div>

<div class="row row-gap-4">
    {{-- chart 1 --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-7" style="height: 800px;">
        <div class="card h-100">
            <div class="card-header">
                <i class="ti ti-keyframes me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Depth sensor data taken from API every 5s</p>
                    <p class="card-title">DEPTH LINE CHART</p>
                </div>
            </div>

            <div class="card-body h-100">
                <div class="d-flex gap-4 justify-content-between">
                    <div class="icon-filter-group">
                        @include('components.btn-filter', [
                            'ic' => 'ti-arrow-down-dashed',
                            'nb' => 'chart-filter-1',
                            'tt' => 'Depth'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-arrows-transfer-up-down',
                            'nb' => 'chart-filter-1',
                            'tt' => 'BV-Depth'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-needle-thread',
                            'nb' => 'chart-filter-1',
                            'tt' => 'Bit-Depth'
                        ])
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="chart1"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- prediction notification --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-5" style="height: 800px;">
        <div class="card predict-notification">
            <div class="card-header">
                <i class="ti ti-tic-tac me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Potential stuck <b>prediction for 5 minute</b> in the future</p>
                    <p class="card-title">POTENTIAL STUCK PREDICTION</p>
                </div>
            </div>
            <div class="card-body">
                <div id="prediction-notification" class="notification"> </div>
            </div>
        </div>
    </div>

    {{-- chart 2 --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6" style="height: 800px;">
        <div class="card">
            <div class="card-header">
                <i class="ti ti-crane me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Drilling sensor data taken from API every 5ss</p>
                    <p class="card-title">DRILLING LINE CHART</p>
                </div>
            </div>

            <div class="card-body h-100">
                <div class="d-flex gap-4 justify-content-between">
                    <div class="icon-filter-group">
                        @include('components.btn-filter', [
                            'ic' => 'ti-whirl',
                            'nb' => 'chart-filter-2',
                            'tt' => 'Torque'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-stack-push',
                            'nb' => 'chart-filter-2',
                            'tt' => 'ROPi'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-arrow-big-down-lines',
                            'nb' => 'chart-filter-2',
                            'tt' => 'WOB'
                        ])
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="chart2"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- chart 3 --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6" style="height: 800px;">
        <div class="card">
            <div class="card-header">
                <i class="ti ti-tournament me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Bit string sensor data taken from API every 5s</p>
                    <p class="card-title">BIT STRING CHART DATA</p>
                </div>
            </div>

            <div class="card-body h-100">
                <div class="d-flex gap-4 justify-content-between">
                    <div class="icon-filter-group">
                        @include('components.btn-filter', [
                            'ic' => 'ti-propeller',
                            'nb' => 'chart-filter-3',
                            'tt' => 'STPPRESS'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-fish-hook',
                            'nb' => 'chart-filter-3',
                            'tt' => 'HKLD'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-texture',
                            'nb' => 'chart-filter-3',
                            'tt' => 'RPM'
                        ])


                        @include('components.btn-filter', [
                            'ic' => 'ti-blocks',
                            'nb' => 'chart-filter-3',
                            'tt' => 'Block-Pos'
                        ])
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="chart3"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>