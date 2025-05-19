<div class="row mb-4">
    <div class="col">
        <p class="page-header mb-0">PREDICTION HISTORIES</p>
        <p class="page-subheader mb-0">All prediction histories for current well</p>
    </div>
</div>

<div class="row row-gap-4">
    {{-- table --}}
    <div class="col-12 ">
        <div class="card h-100">
            <div class="card-header has-icons">
                <div class="text-header">
                    <i class="ti ti-chart-column me-1 d-none d-sm-block"></i>
                    <div class="container-column">
                        <p class="card-subtitle">Potential Stuck Prediction Histories</p>
                        <p class="card-title">PREDICTION TABLE</p>
                    </div>
                </div>

                <div class="icon-export">
                    <span id="btn-refresh-id" class="icons btn-refresh"><i class="ti ti-rotate-2"></i></span>
                    <span id="btn-export-pdf-id" class="icons btn-export-pdf d-none"><i class="ti ti-file-type-pdf"></i></span>
                    <span id="btn-export-excell-id" class="icons btn-export-excell d-none"><i class="ti ti-file-type-xls"></i></span>
                    <span id="btn-export-print-id" class="icons btn-export-print d-none"><i class="ti ti-printer"></i></span>
                </div>
            </div>

            <div class="card-body h-100 gap-2">
                <div id="form-filter" class="container-column gap-2">
                    <div class="row row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                            <label for="filter-date" class="form-label"><i class="ti ti-calendar-month me-1"></i> Filter Date </label>
                            <input type="text" id="filter-date" name="filter-date" class="form-control"></input>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="table-notification" class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th id="pred-id"        class="text-center">id</th>
                                <th id="pred-date"      class="text-center">Prediction Date</th>
                                <th id="pred-record-en" class="text-center d-none d-xl-table-cell">Record Date Start</th>
                                <th id="pred-record-st" class="text-center d-none d-xl-table-cell">Record Date End</th>
                                <th id="pred-well-tk"   class="text-center">Token</th>
                                <th id="pred-well-id"   class="text-center">Well Name</th>
                                <th id="pred-stats_sr"  class="text-center">Torque</th>
                                <th id="pred-stats_cr"  class="text-center">Circulation</th>
                                <th id="pred-stats_rt"  class="text-center">RPM</th>
                                <th id="pred-stats_sl"  class="text-center">Stall</th>
                                <th id="pred-stats_cl"  class="text-center">Clean BS</th>
                                <th id="pred-well-pr"   class="text-center">Prediction</th>
                                <th id="pred-message"   class="text-center">Notes</th>
                                <th id="pred-message"   class="text-center">View Data</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="col-12">
        <div class="d-flex align-items-center">
            <p id="title-prediction" class="page-header mb-0 me-2">PREDICTION DATA</p>
            <div><span id="view-data-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span></div>
        </div>
        <p id="subtitle-prediction" class="page-subheader mb-0">No Data! Please select prediction date!</p>
    </div>

    {{-- chart 4 --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6" style="height: 1200px;">
        <div class="card h-100">
            <div class="card-header">
                <i class="ti ti-keyframes me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Depth sensor data used in the selected prediction date</p>
                    <p class="card-title">DEPTH LINE CHART</p>
                </div>
            </div>

            <div class="card-body h-100">
                <div class="d-flex gap-4 justify-content-between">
                    <div class="icon-filter-group">
                        @include('components.btn-filter', [
                            'ic' => 'ti-arrow-down-dashed',
                            'nb' => 'chart-filter-4',
                            'tt' => 'Depth'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-arrows-transfer-up-down',
                            'nb' => 'chart-filter-4',
                            'tt' => 'BV-Depth'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-needle-thread',
                            'nb' => 'chart-filter-4',
                            'tt' => 'Bit-Depth'
                        ])
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="chart4"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- chart 5 --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6" style="height: 1200px;">
        <div class="card">
            <div class="card-header">
                <i class="ti ti-crane me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Drilling sensor data used in the selected prediction date</p>
                    <p class="card-title">DRILLING LINE CHART</p>
                </div>
            </div>

            <div class="card-body h-100">
                <div class="d-flex gap-4 justify-content-between">
                    <div class="icon-filter-group">
                        @include('components.btn-filter', [
                            'ic' => 'ti-whirl',
                            'nb' => 'chart-filter-5',
                            'tt' => 'Torque'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-stack-push',
                            'nb' => 'chart-filter-5',
                            'tt' => 'ROPi'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-arrow-big-down-lines',
                            'nb' => 'chart-filter-5',
                            'tt' => 'WOB'
                        ])
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="chart5"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- chart 6 --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6" style="height: 1200px;">
        <div class="card">
            <div class="card-header">
                <i class="ti ti-tournament me-1 d-none d-sm-block"></i>
                <div class="container-column">
                    <p class="card-subtitle">Bit String data used in the selected prediction date</p>
                    <p class="card-title">BIT STRING CHART DATA</p>
                </div>
            </div>

            <div class="card-body h-100">
                <div class="d-flex gap-4 justify-content-between">
                    <div class="icon-filter-group">
                        @include('components.btn-filter', [
                            'ic' => 'ti-propeller',
                            'nb' => 'chart-filter-6',
                            'tt' => 'STPPRESS'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-fish-hook',
                            'nb' => 'chart-filter-6',
                            'tt' => 'HKLD'
                        ])

                        @include('components.btn-filter', [
                            'ic' => 'ti-texture',
                            'nb' => 'chart-filter-6',
                            'tt' => 'RPM'
                        ])


                        @include('components.btn-filter', [
                            'ic' => 'ti-blocks',
                            'nb' => 'chart-filter-6',
                            'tt' => 'Block-Pos'
                        ])
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="chart6"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>