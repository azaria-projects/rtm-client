<aside class="app-sidebar sidebar-rtdm" data-bs-theme="dark">
    @include('components.aside-user')

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <li class="nav-header">Depth Sensors</li>
                @include('components.aside-items', [
                    'ic' => 'ti-arrow-down-dashed',
                    'nm' => 'Depth',
                    'mt' => 'm',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-arrows-transfer-up-down',
                    'nm' => 'BV-Depth',
                    'mt' => 'm',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-needle-thread',
                    'nm' => 'Bit-Depth',
                    'mt' => 'm',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-blocks',
                    'nm' => 'Block Pos.',
                    'mt' => 'm',
                ])

                <li class="nav-header mt-2">Drilling Sensors</li>
                @include('components.aside-items', [
                    'ic' => 'ti-whirl',
                    'nm' => 'Torque',
                    'mt' => 'klb.ft',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-propeller',
                    'nm' => 'RPM',
                    'mt' => 'min',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-arrow-big-down-lines',
                    'nm' => 'ROPi',
                    'mt' => 'm/hr',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-fish-hook',
                    'nm' => 'HKLD',
                    'mt' => 'klb',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-stack-push',
                    'nm' => 'WOB',
                    'mt' => 'klb',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-texture',
                    'nm' => 'STPRESS',
                    'mt' => 'psi',
                ])
                
                <li class="nav-header mt-2">Circulation Sensors</li>
                @include('components.aside-items', [
                    'ic' => 'ti-ripple',
                    'nm' => 'Flow In',
                    'mt' => 'gpm',
                ])

                @include('components.aside-items', [
                    'ic' => 'ti-puzzle-2',
                    'nm' => 'Flow Out',
                    'mt' => 'gpm',
                ])

                <li class="nav-header mt-2">Other Sensors</li>
                @include('components.aside-items', [
                    'ic' => 'ti-wind',
                    'nm' => 'SCFM',
                    'mt' => 'f3/m',
                ])

                {{-- <li class="nav-header mt-auto">System</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="row well-params w-100">
                            <div class="col-12 param-data" style="background-color: transparent;">
                                <i class="nav-icon ti ti-power"></i>
                                <p class="data-title">LOGOUT</p>
                            </div>
                        </div>
                    </a>
                </li> --}}
            </ul>
        </nav>
    </div>
</aside>
