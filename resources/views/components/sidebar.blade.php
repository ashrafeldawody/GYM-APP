<div>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
        <a href="#" class="brand-link">
            <img src="{{url('dist/img/AdminLTELogo.png')}}" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel App') }}</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{Auth::user()->avatar ? Auth::user()->avatar : 'https://ui-avatars.com/api/?name=' . Auth::user()->name}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{route('dashboard.cities.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-globe-americas"></i>
                            <p>
                                Cities
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-dumbbell"></i>
                            <p>
                                Gyms
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Managers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                Training Packages
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('dashboard.packages.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Packages</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('dashboard.purchases.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase Package</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('dashboard.sessions.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Training Sessions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Couches</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('dashboard.users.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('dashboard.attendance.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-user-clock"></i>
                            <p>Attendance</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Revenue</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Account Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</div>
