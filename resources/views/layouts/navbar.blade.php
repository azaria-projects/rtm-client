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

            <li class="nav-item"> 
                <div class="icon-filter-group">
                    <div class="icon-filter">
                        <span id="date-time" class="datetime me-2 text-center"></span>
                        <i class="ti ti-calendar-clock me-2"></i>
                    </div>

                    <div class="btn-logout only-icon-filter" style="cursor: pointer;">
                        <i class="ti ti-power"></i>
                    </div>
    
                    <div class="only-icon-filter active">
                        <i class="ti ti-layout-sidebar-right-expand" data-lte-toggle="sidebar" href="#" role="button"></i>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
