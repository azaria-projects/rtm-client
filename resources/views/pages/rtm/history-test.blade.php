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

    {{-- depth chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'depth',
            'ccn' => 'v-depth',
            'csb' => 'Sensor Data',
            'clg' => 'ti-arrow-down-dashed',
        ])
    </div>

    {{-- bitdepth chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'bitdepth',
            'ccn' => 'v-bitdepth',
            'csb' => 'Sensor Data',
            'clg' => 'ti-arrows-transfer-up-down',
        ])
    </div>

    {{-- bvdepth chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'bvdepth',
            'ccn' => 'v-bvdepth',
            'csb' => 'Sensor Data',
            'clg' => 'ti-needle-thread',
        ])
    </div>

    {{-- bvdepth chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'block-pos',
            'ccn' => 'v-blockpos',
            'csb' => 'Sensor Data',
            'clg' => 'ti-blocks',
        ])
    </div>

    {{-- torque chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'torque',
            'ccn' => 'v-torque',
            'csb' => 'Sensor Data',
            'clg' => 'ti-whirl',
        ])
    </div>

    {{-- ropi chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'ropi',
            'ccn' => 'v-ropi',
            'csb' => 'Sensor Data',
            'clg' => 'ti-arrow-big-down-lines',
        ])
    </div>

    {{-- wob chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'wob',
            'ccn' => 'v-wob',
            'csb' => 'Sensor Data',
            'clg' => 'ti-stack-push',
        ])
    </div>

    {{-- stppress chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'stppress',
            'ccn' => 'v-stppress',
            'csb' => 'Sensor Data',
            'clg' => 'ti-texture',
        ])
    </div>

    {{-- hkld chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'hkld',
            'ccn' => 'v-hkld',
            'csb' => 'Sensor Data',
            'clg' => 'ti-fish-hook',
        ])
    </div>
    
    {{-- rpm chart --}}
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
        @include('components.chart-graph', [
            'cti' => 'rpm',
            'ccn' => 'v-rpm',
            'csb' => 'Sensor Data',
            'clg' => 'ti-propeller',
        ])
    </div>
</div>