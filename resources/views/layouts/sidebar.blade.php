<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-code"></i>
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

    <!-- Nav Item - Tools Management Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTools"
            aria-expanded="true" aria-controls="collapseTools">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Tools Management</span>
        </a>
        <div id="collapseTools" class="collapse" aria-labelledby="headingTools"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('tools.index') }}">Tools</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Equipment Management Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEquipment"
            aria-expanded="true" aria-controls="collapseEquipment">
            <i class="fas fa-fw fa-screwdriver-wrench"></i>
            <span>Equip Management</span>
        </a>
        <div id="collapseEquipment" class="collapse" aria-labelledby="headingEquipment"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('equipments.index') }}">Equipment</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Vehicles Management Collapse Menu -->
    <li class="nav-item {{ Nav::isRoute('vehicles.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVehicles"
            aria-expanded="true" aria-controls="collapseVehicles">
            <i class="fas fa-fw fa-truck-fast"></i>
            <span>Vehicles Management</span>
        </a>
        <div id="collapseVehicles" class="collapse {{ Nav::isRoute('vehicles.index') ? 'show' : ''}}" aria-labelledby="headingVehicles"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('vehicles.index') }}">Vehicles</a>
                <a class="collapse-item" href="{{ route('maintenances.index') }}">Maintanance</a>
                <a class="collapse-item" href="{{ route('insurances.index') }}">Assurance</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Vehicles Management Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVouchers"
            aria-expanded="true" aria-controls="collapseVouchers">
            <i class="fas fa-fw fa-ticket"></i>
            <span>Vouchers Management</span>
        </a>
        <div id="collapseVouchers" class="collapse" aria-labelledby="headingVouchers"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('vouchers.index') }}">Vouchers</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tickecting Management Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTicketing"
            aria-expanded="true" aria-controls="collapseTicketing">
            <i class="fas fa-fw fa-hands-holding-child"></i>
            <span>Ticketing Management</span>
        </a>
        <div id="collapseTicketing" class="collapse" aria-labelledby="headingTicketing"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('ticketing.index') }}">Ticketing</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Settings') }}
    </div>

    <!-- Nav Item - Users Management Collapse Menu -->
    <li class="nav-item {{ Nav::isRoute('users.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
            aria-expanded="true" aria-controls="collapseUsers">
            <i class="fas fa-fw fa-users-gear"></i>
            <span>Users Management</span>
        </a>
        <div id="collapseUsers" class="collapse {{ Nav::isRoute('users.index') ? 'show' : ''}}" aria-labelledby="headingUsers"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('users.index') }}">Users</a>
                <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
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