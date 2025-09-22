<nav class="app-header navbar navbar-expand">
    <div class="container-fluid">
        <ul class="navbar-nav">
            @include('components.nav-items', [
                'dt' => 'no data',
                'br' => 'lg', 
                'ic' => 'ti-file-info',
                'tt' => 'File Name'
            ])

            @include('components.nav-items', [
                'dt' => '0 KB',
                'br' => 'lg', 
                'ic' => 'ti-ruler-measure-2',
                'tt' => 'File Size'
            ])

            <li class="nav-item" style="overflow-x: scroll"> 
                <div class="icon-filter-group">
                    <div class="icon-filter" style="pointer-events: none !important;">
                        <span id="date-time" class="datetime me-2 text-center"></span>
                        <i class="ti ti-calendar-clock me-2"></i>
                    </div>

                    @if (Route::currentRouteName() !== 'rtm.test')
                        <div class="btn-logout only-icon-filter active" style="cursor: pointer;">
                            <i class="ti ti-power"></i>
                        </div>
                    @endif

                    <div class="btn-services only-icon-filter active" style="cursor: pointer; text-decoration: none;">
                        <i class="ti ti-server-2"></i>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
