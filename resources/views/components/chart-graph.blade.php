<div class="card h-100">
    <div class="card-header">
        <i class="ti {{ $clg ?? 'ti-keyframes' }} me-1 d-none d-sm-block"></i>
        <div class="container-column">
            <p class="card-subtitle">{{ $csb ?? 'Sensor Data' }}</p>
            <p class="card-title">{{ isset($cti) ? strtoupper($cti) : 'DATA' }}</p>
        </div>
    </div>

    <div class="card-body h-100">
        <div class="chart-container" style="height: 450px;">
            <canvas id="chart-{{ $ccn ?? 'data' }}"></canvas>
        </div>
    </div>
</div>