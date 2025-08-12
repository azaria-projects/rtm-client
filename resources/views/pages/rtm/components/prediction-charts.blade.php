<div class="card h-100">
    <div class="card-header">
        <i class="ti ti-keyframes me-1 d-none d-sm-block"></i>
        <div class="container-column">
            <p class="card-subtitle">Sensor data taken from API every 5s</p>
            <p class="card-title d-flex align-items-center me-4">PREDICTION DATA <span id="view-data-spinner" class="spinner-border spinner-border-sm d-none ms-2" role="status"></span></p>
        </div>
    </div>

    <div class="card-body h-100">
        <div class="row flex-nowrap overflow-auto m-0 p-0 w-100" style="height: 805px;">
            @foreach ($chr as $chartName)
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 m-0 p-0 h-100">
                    <div class="chart-container m-0 p-0" style="height: 800px;">
                        <canvas id="{{ 'chart-v-' . $chartName }}" class="m-0 p-0" style="border: 0;"></canvas>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>