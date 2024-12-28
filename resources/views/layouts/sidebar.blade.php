<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-code"></i>
            {{-- <i class="fas fa-star-of-david"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">UDPORTAL</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    @can('create ticket')
    <!-- Nav Item - Kontract Management-->
    <li class="nav-item {{ Nav::isRoute('ticketing.create') }}">
        <a class="nav-link" href="{{ route('ticketing.create') }}">
            <i class="fas fa-fw fa-receipt"></i>
            <span>{{ __('Create Ticketing') }}</span></a>
    </li>
    @endcan

    @can('view contracts')
    <!-- Nav Item - Kontract Management-->
    <li class="nav-item {{ Nav::isRoute('contract.index') }}">
        <a class="nav-link" href="{{ route('contract.index') }}">
            <i class="fas fa-fw fa-address-card"></i>
            <span>Contract Management</span></a>
    </li>
    @endcan

    <!-- Nav Item - Tools Management Collapse Menu -->
    @can('view tools')
    <li class="nav-item {{ request()->routeIs(['tools.*', 'tracking.*', 'dn-transport.index','transactions.*', 'projects.*','tools-maintenances.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTools"
            aria-expanded="true" aria-controls="collapseTools">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Tools Management</span>
        </a>
        <div id="collapseTools" class="collapse {{ request()->routeIs(['tools.*', 'tracking.*', 'dn-transport.index', 'tools-maintenances.*','transactions.*' ,'projects.*']) ? 'show' : '' }}" aria-labelledby="headingTools"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('tools.*') ? 'active' : '' }}" href="{{ route('tools.index') }}">Tools</a>
                <a class="collapse-item {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">Project</a>
                <a class="collapse-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transactions</a>
                <a class="collapse-item {{ request()->routeIs('tracking.*') ? 'active' : '' }}" href="{{ route('tracking.index') }}">Tracking</a>
                @can('view tools maintenance')
                <a class="collapse-item {{ request()->routeIs('tools-maintenances.index') ? 'active' : '' }}" href="{{ route('tools-maintenances.index') }}">Maintenances</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    {{-- <!-- Nav Item - Vehicles Management Collapse Menu -->
    @can('view vehicle')
    <li class="nav-item {{ request()->routeIs(['vehicles.index', 'vehicles-maintenances.index', 'insurances.index', 'vehicles-assign.index', 'vehicles.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVehicles"
            aria-expanded="true" aria-controls="collapseVehicles">
            <i class="fas fa-fw fa-truck-fast"></i>
            <span>Vehicles Management</span>
        </a>
        <div id="collapseVehicles" class="collapse {{ request()->routeIs(['vehicles.index', 'vehicles-maintenances.index', 'insurances.index','vehicles-assign.index' ,'vehicles.*']) ? 'show' : '' }}" aria-labelledby="headingVehicles"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('vehicles.index') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">{{ __('Vehicles') }}</a>
                <a class="collapse-item {{ request()->routeIs('vehicles-assign.index') ? 'active' : '' }}" href="{{ route('vehicles-assign.index') }}">Assignment</a>
                @can('view maintenance')
                <a class="collapse-item {{ request()->routeIs('vehicles-maintenances.index') ? 'active' : '' }}" href="{{ route('vehicles-maintenances.index') }}">{{ __('Maintenances') }}</a>
                @endcan
                @can('view insurance')
                <a class="collapse-item {{ request()->routeIs('insurances.index') ? 'active' : '' }}" href="{{ route('insurances.index') }}">{{ __('Insurances') }}</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan --}}

    <!-- Nav Item - Vouchers Management Collapse Menu -->
    {{-- @can('view vouchers')
    <li class="nav-item {{ request()->routeIs('vouchers.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVouchers"
            aria-expanded="true" aria-controls="collapseVouchers">
            <i class="fas fa-fw fa-ticket"></i>
            <span>Vouchers Management</span>
        </a>
        <div id="collapseVouchers" class="collapse {{ request()->routeIs('vouchers.index') ? 'show' : '' }}" aria-labelledby="headingVouchers"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('vouchers.index') ? 'active' : '' }}" href="{{ route('vouchers.index') }}">{{ __('Vouchers') }}</a>
            </div>
        </div>
    </li>
    @endcan --}}
    
    <!-- Nav Item - Equipment Management Collapse Menu -->
    {{-- @can('view equipments')
    <li class="nav-item {{ request()->routeIs('equipments.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEquipment"
            aria-expanded="true" aria-controls="collapseEquipment">
            <i class="fas fa-fw fa-screwdriver-wrench"></i>
            <span>Equip Management</span>
        </a>
        <div id="collapseEquipment" class="collapse {{ request()->routeIs('equipments.index') ? 'show' : '' }}" aria-labelledby="headingEquipment"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('equipments.index') ? 'active' : '' }}" href="{{ route('equipments.index') }}">Equipment</a>
            </div>
        </div>
    </li>
    @endcan --}}

    @can('view ticket')
    <!-- Nav Item - Tickecting Management Collapse Menu -->
    <li class="nav-item {{ request()->routeIs(['ticketing.index', 'ticketing-categories.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTicketing"
            aria-expanded="true" aria-controls="collapseTicketing">
            <i class="fas fa-fw fa-hands-holding-child"></i>
            <span>Ticketing Management</span>
        </a>
        <div id="collapseTicketing" class="collapse {{ request()->routeIs(['ticketing.index', 'ticketing-categories.*']) ? 'show' : '' }}" aria-labelledby="headingTicketing"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('ticketing.index') ? 'active' : '' }}" href="{{ route('ticketing.index') }}">{{ __('Ticketing') }}</a>
                <a class="collapse-item {{ request()->routeIs('ticketing-categories.index') ? 'active' : '' }}" href="{{ route('ticketing-categories.index') }}">{{ __('Ticketing Category') }}</a>
            </div>
        </div>
    </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Settings') }}
    </div>

    <!-- Nav Item - Companies Management Collapse Menu -->
    @can('view company')
    <li class="nav-item {{ request()->routeIs(['companies.index', 'branches.index', 'departments.index', 'employees.index']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompenies"
            aria-expanded="true" aria-controls="collapseCompenies">
            <i class="fas fa-fw fa-building"></i>
            <span>Company Management</span>
        </a>
        <div id="collapseCompenies" class="collapse {{ request()->routeIs(['companies.index', 'branches.index', 'departments.index', 'employees.index']) ? 'show' : '' }}" aria-labelledby="headingCompenies"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('companies.index') ? 'active' : '' }}" href="{{ route('companies.index') }}">Companies</a>
                <a class="collapse-item {{ request()->routeIs('branches.index') ? 'active' : '' }}" href="{{ route('branches.index') }}">Branches</a>
                <a class="collapse-item {{ request()->routeIs('departments.index') ? 'active' : '' }}" href="{{ route('departments.index') }}">Departments</a>
                <a class="collapse-item {{ request()->routeIs('employees.index') ? 'active' : '' }}" href="{{ route('employees.index') }}">Employees</a>
            </div>
        </div>
    </li>
    @endcan


    <!-- Nav Item - Users Management Collapse Menu -->
    @can('view users')
    <li class="nav-item {{ request()->routeIs(['users.index', 'roles.index']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
            aria-expanded="true" aria-controls="collapseUsers">
            <i class="fas fa-fw fa-users-gear"></i>
            <span>Users Management</span>
        </a>
        <div id="collapseUsers" class="collapse {{ request()->routeIs(['users.index', 'roles.index']) ? 'show' : '' }}" aria-labelledby="headingUsers"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a>
                @can('view roles')
                <a class="collapse-item {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles & Permissions</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    
    <!-- Nav Item - Profile -->
    <li class="nav-item {{ Nav::isRoute('profile') }}">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Profile') }}</span>
        </a>
    </li>

    <!-- Nav Item - About -->
    <li class="nav-item {{ Nav::isRoute('about') }}">
        <a class="nav-link" href="{{ route('about') }}">
            <i class="fas fa-fw fa-hands-helping"></i>
            <span>{{ __('About') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>