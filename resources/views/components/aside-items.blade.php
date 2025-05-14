<li class="nav-item" style="pointer-events: none !important;">
    <a href="#" class="nav-link">
        <div class="row well-params w-100">
            <div id="{{ isset($nm) ? 'label-' . str_replace(' ', '-', strtolower($nm)) : 'no-data-label' }}" class="col-7 param-data">
                <i class="nav-icon ti {{ $ic ?? 'ti-brand-databricks' }}"></i>
                <p id="{{ isset($nm) ? str_replace(' ', '-', strtolower($nm)) : 'no-data-title' }}" class="data-title">{{ $nm ?? 'No Data' }}</p>
            </div>
            <div class="col-5 param-value">
                <p class="data-value">
                    <span id="{{ isset($nm) ? 'value-' . str_replace(' ', '-', strtolower($nm)) : 'no-data-value' }}">{{ $vl ?? 0 }}</span>
                    <span id="{{ isset($nm) ? 'metric-' . str_replace(' ', '-', strtolower($nm)) : 'no-data-metrics' }}" class="data-metric">{{ $mt ?? 'psi' }}</span>
                </p>
            </div>
        </div>
    </a>
</li>