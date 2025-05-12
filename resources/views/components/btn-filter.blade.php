<div id="{{ isset($tt) ? 'chart-' . str_replace(' ', '-', strtolower($tt)) : 'no-data' }}" class="icon-filter {{ $nb ?? '' }} px-3" data-chart="{{ isset($tt) ? str_replace(' ', '-', strtolower($tt)) : '' }}">
    <i class="ti {{ $ic ?? 'ti-hourglass' }}"></i>
    <span>{{ $tt ?? '' }}</span>
</div>