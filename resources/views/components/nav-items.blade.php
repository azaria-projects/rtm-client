<li class="nav-item d-none d-{{ $br ?? 'xl' }}-flex align-items-center" style="pointer-events: none;">
    <a href="#" class="nav-link info-box">
        <span class="info-box-icon text-bg-primary shadow-sm"> <i class="ti {{ $ic ?? 'ti-brand-databricks' }}"></i> </span>
        <div class="info-box-content">
            <span id="{{ isset($dt) ? str_replace(' ', '-', strtolower($tt)). '-id' : 'no-data-id' }}" class="info-box-text">{{ $tt ?? 'title' }}</span>
            <span id="{{ isset($dt) ? str_replace(' ', '-', strtolower($dt)). '-id' : 'no-data-id' }}" class="info-box-number">{{ $dt ?? 'data' }}</span>
        </div>
    </a>
</li>