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

    @can('view contracts')
    <!-- Nav Item - Kontract Management-->
    <li class="nav-item {{ Nav::isRoute('contract.*') }}">
        <a class="nav-link" href="{{ route('contract.index') }}">
            <i class="fas fa-fw fa-file-contract"></i>
            <span>Contract Management</span></a>
    </li>
    @endcan

    @can('create ticket')
    <!-- Nav Item - Kontract Management-->
    <li class="nav-item {{ Nav::isRoute('ticketing.create') }}">
        <a class="nav-link" href="{{ route('ticketing.create') }}">
            <i class="fas fa-fw fa-receipt"></i>
            <span>{{ __('Create Ticketing') }}</span></a>
    </li>
    @endcan

    <!-- Nav Item - Tickecting Management Collapse Menu -->
    @can('view ticket')
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

    <!-- Nav Item - Tools Management Collapse Menu -->
    @can('view tools')
    <li class="nav-item {{ request()->routeIs(['tools.*','transactions.*', 'projects.*','tools-maintenances.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTools"
            aria-expanded="true" aria-controls="collapseTools">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Tools Management</span>
        </a>
        <div id="collapseTools" class="collapse {{ request()->routeIs(['tools.*', 'tools-maintenances.*','transactions.*' ,'projects.*']) ? 'show' : '' }}" aria-labelledby="headingTools"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('tools.*') ? 'active' : '' }}" href="{{ route('tools.index') }}">Tools</a>
                <a class="collapse-item {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">Project</a>
                <a class="collapse-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transactions</a>
                <a class="collapse-item {{ request()->routeIs('tools-maintenances.index') ? 'active' : '' }}" href="{{ route('tools-maintenances.index') }}">Maintenances</a>
            </div>
        </div>
    </li>
    @endcan

    <!-- Nav Item - Vehicles Management Collapse Menu -->
    <li class="nav-item {{ request()->routeIs(['vehicles.*', 'vehicles-maintenances.*', 'insurances.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVehicles"
            aria-expanded="true" aria-controls="collapseVehicles">
            <i class="fas fa-fw fa-truck-fast"></i>
            <span>Vehicles Management</span>
        </a>
        <div id="collapseVehicles" class="collapse {{ request()->routeIs(['vehicles.*', 'vehicles-maintenances.*', 'insurances.*']) ? 'show' : '' }}" aria-labelledby="headingVehicles"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">{{ __('Vehicles') }}</a>
                <a class="collapse-item {{ request()->routeIs('vehicles-maintenances.*') ? 'active' : '' }}" href="{{ route('vehicles-maintenances.index') }}">{{ __('Maintenances') }}</a>
                <a class="collapse-item {{ request()->routeIs('insurances.*') ? 'active' : '' }}" href="{{ route('insurances.index') }}">{{ __('Insurances') }}</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Incomings Inventory Plan Collapse Menu -->
    <li class="nav-item {{ request()->routeIs(['incomings-supplier.*', 'incomings-inventory.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIncomings"
            aria-expanded="true" aria-controls="collapseIncomings">
            <i class="fas fa-fw fa-truck-fast"></i>
            <span>Incomings Inven Plan</span>
        </a>
        <div id="collapseIncomings" class="collapse {{ request()->routeIs(['incomings-supplier.*', 'incomings-inventory.*']) ? 'show' : '' }}" aria-labelledby="headingIncomings"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('incomings-supplier.*') ? 'active' : '' }}" href="{{ route('incomings-supplier.index') }}">{{ __('Supplier') }}</a>
                <a class="collapse-item {{ request()->routeIs('incomings-inventory.*') ? 'active' : '' }}" href="{{ route('incomings-inventory.index') }}">{{ __('Incomings Inventory') }}</a>
            </div>
        </div>
    </li>

    <!-- Cost Bid Analysis Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCostBidAnalysis" 
            aria-expanded="true" aria-controls="collapseCostBidAnalysis">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Cost Bid Analysis</span>
        </a>
        <div id="collapseCostBidAnalysis" class="collapse" aria-labelledby="headingCostBidAnalysis" 
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="">{{ __('Cost Bid Vendor') }}</a>
                {{-- <a class="collapse-item" href="">{{ __('Cost Bid Inventory') }}</a> --}}
                <a class="collapse-item" href="">{{ __('Cost Bid Analysis') }}</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Business Master Collapse Menu -->
    <li class="nav-item ">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBusiness"
            aria-expanded="true" aria-controls="collapseBusiness">
            <i class="fas fa-fw fa-users"></i>
            <span>Business Partner</span>
        </a>
        <div id="collapseBusiness" class="collapse" aria-labelledby="headingBusiness"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('bussines-master.index') }}">{{ __('Business Master') }}</a>
                <a class="collapse-item" href="">{{ __('Activity') }}</a>
                <a class="collapse-item" href="">{{ __('Campaign Generation Wizard') }}</a>
                <a class="collapse-item" href="">{{ __('Campaign') }}</a>
                <a class="collapse-item" href="">{{ __('Internal Reconciliations') }}</a>
                <a class="collapse-item" href="">{{ __('Business Partner Report') }}</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Settings') }}
    </div>

    <!-- Nav Item - Companies Management Collapse Menu -->
    <li class="nav-item {{ request()->routeIs(['companies.*', 'branches.*', 'warehouses.*','departments.*', 'employees.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompenies"
            aria-expanded="true" aria-controls="collapseCompenies">
            <i class="fas fa-fw fa-building"></i>
            <span>Company Management</span>
        </a>
        <div id="collapseCompenies" class="collapse {{ request()->routeIs(['companies.*', 'branches.*','warehouses.*', 'departments.*', 'employees.*']) ? 'show' : '' }}" aria-labelledby="headingCompenies"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('companies.index') ? 'active' : '' }}" href="{{ route('companies.index') }}">Companies</a>
                <a class="collapse-item {{ request()->routeIs('branches.index') ? 'active' : '' }}" href="{{ route('branches.index') }}">Branches</a>
                <a class="collapse-item {{ request()->routeIs('warehouses.index') ? 'active' : '' }}" href="{{ route('warehouses.index') }}">Warehouses</a>
                <a class="collapse-item {{ request()->routeIs('departments.index') ? 'active' : '' }}" href="{{ route('departments.index') }}">Departments</a>
                <a class="collapse-item {{ request()->routeIs('employees.index') ? 'active' : '' }}" href="{{ route('employees.index') }}">Employees</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Users Management Collapse Menu -->
    <li class="nav-item {{ request()->routeIs(['users.*', 'roles.*']) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
            aria-expanded="true" aria-controls="collapseUsers">
            <i class="fas fa-fw fa-users-gear"></i>
            <span>Users Management</span>
        </a>
        <div id="collapseUsers" class="collapse {{ request()->routeIs(['users.*', 'roles.*']) ? 'show' : '' }}" aria-labelledby="headingUsers"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Users Account</a>
                <a class="collapse-item {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles & Permissions</a>
            </div>
        </div>
    </li>
    
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