<nav class="app-header navbar navbar-expand">
    <div class="container-fluid">
        <ul class="navbar-nav">
            @include('components.nav-items', [
                'dt' => $com,
                'br' => 'lg', 
                'ic' => 'ti-backhoe',
                'tt' => 'Company Name'
            ])

            @include('components.nav-items', [
                'dt' => $nme,
                'br' => 'lg', 
                'ic' => 'ti-pool',
                'tt' => 'Well Name' 
            ])

            @include('components.nav-items', [
                'tt' => 'Well Status', 
                'ic' => 'ti-satellite', 
                'dt' => strtolower($sat) == 'yes' ? 'active' : 'inactive'
            ])

            @include('components.nav-items', [
                'dt' => $typ,
                'tt' => 'Well Type', 
                'ic' => 'ti-gas-station'
            ])

            <li class="nav-item" style="overflow-x: scroll"> 
                <div class="icon-filter-group">
                    <div class="icon-filter" style="pointer-events: none !important;">
                        <span id="date-time" class="datetime me-2 text-center"></span>
                        <i class="ti ti-calendar-clock me-2"></i>
                    </div>

                    @if (Route::currentRouteName() !== 'rtm.test')
                        <div class="btn-logout only-icon-filter" style="cursor: pointer;">
                            <i class="ti ti-power"></i>
                        </div>
                    @endif
    
                    <div class="only-icon-filter" data-lte-toggle="sidebar" role="button">
                        <i class="ti ti-layout-sidebar-right-expand"></i>
                    </div>

                    <div class="btn-home only-icon-filter active" style="cursor: pointer; text-decoration: none;">
                        <i class="ti ti-bell-ringing"></i>
                    </div>

                    <div class="btn-home only-icon-filter active" style="cursor: pointer; text-decoration: none;">
                        <i class="ti ti-home-spark"></i>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
