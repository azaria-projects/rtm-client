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
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <label for="filter-date" class="form-label"><i class="ti ti-calendar-month me-1"></i> Filter Date </label>
                    <input type="text" id="filter-date" name="filter-date" class="form-control"></input>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="table-predictions" class="table table-striped">
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