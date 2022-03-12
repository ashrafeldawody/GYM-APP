<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img src="{{url('dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
    </div>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed h-100">
        <a href="#" class="brand-link">
            <img src="{{url('dist/img/AdminLTELogo.png')}}" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel App') }}</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
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
                    <a href="{{route('dashboard.home.index')}}" class="nav-link {{ Route::is('dashboard.home.index') ? 'active':''}}">
                        <i class="nav-icon fas fa-globe-americas"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @can('show_city_data')
                    <li class="nav-item">
                        <a href="{{route('dashboard.cities.index')}}" class="nav-link {{ Route::is('dashboard.cities.index') ? 'active':''}}">
                            <i class="nav-icon fas fa-globe-americas"></i>
                            <p>
                                Cities
                            </p>
                        </a>
                    </li>
                @endcan
                @can('show_gym_data')
                    <li class="nav-item">
                        <a href="{{route('dashboard.gyms.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-dumbbell"></i>
                            <p>
                                Gyms
                            </p>
                        </a>
                    </li>
                @endcan
                @role('admin')
                    <li class="nav-item {{ (Route::is('dashboard.city_managers.index') ||Route::is('dashboard.gym_managers.index') || Route::is('dashboard.general_managers.index') || Route::is('dashboard.coaches.index'))? 'menu-open':''}}">
                        <a href="#" class="nav-link {{ (Route::is('dashboard.city_managers.index') ||Route::is('dashboard.gym_managers.index') || Route::is('dashboard.general_managers.index') || Route::is('dashboard.coaches.index'))? 'active':''}}">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                Employees
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('dashboard.city_managers.index')}}" class="nav-link {{ Route::is('dashboard.city_managers.index') ? 'active':''}}">
                                    <i class="nav-icon fas fa-globe-americas"></i>
                                    <p>City Managers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('dashboard.gym_managers.index')}}" class="nav-link {{ Route::is('dashboard.gym_managers.index') ? 'active':''}}">
                                    <i class="nav-icon fas fa-dumbbell"></i>
                                    <p>Gym Managers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('dashboard.general_managers.index')}}" class="nav-link {{ Route::is('dashboard.general_managers.index') ? 'active':''}}">
                                    <i class="nav-icon fas fa-dumbbell"></i>
                                    <p>General Managers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('dashboard.coaches.index')}}" class="nav-link {{ Route::is('dashboard.coaches.index') ? 'active':''}}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Couches</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @can('gym_managers')
                    <li class="nav-item">
                        <a href="{{route('dashboard.gym_managers.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-dumbbell"></i>
                            <p>Gym Managers</p>
                        </a>
                    </li>
                @endcan
                    <li class="nav-item">
                        <a href="{{route('dashboard.coaches.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Couches</p>
                        </a>
                    </li>
                @endrole
                    <li class="nav-item">
                        <a href="{{route('dashboard.users.index')}}" class="nav-link  {{ Route::is('dashboard.users.index') ? 'active':''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('dashboard.sessions.index')}}" class="nav-link  {{ Route::is('dashboard.sessions.index') ? 'active':''}}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Training Sessions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('dashboard.attendance.index')}}" class="nav-link  {{ Route::is('dashboard.attendance.index') ? 'active':''}}">
                            <i class="nav-icon fas fa-user-clock"></i>
                            <p>Attendance</p>
                        </a>
                    </li>
                @role('admin')
                    <li class="nav-item {{ (Route::is('dashboard.packages.index') ||Route::is('dashboard.purchases.create'))? 'menu-open':''}}">
                        <a href="#" class="nav-link {{ (Route::is('dashboard.packages.index') ||Route::is('dashboard.purchases.create'))? 'active':''}}">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                Training Packages
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('dashboard.packages.index')}}" class="nav-link {{ Route::is('dashboard.packages.index') ? 'active':''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Packages</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('dashboard.purchases.create')}}" class="nav-link {{ Route::is('dashboard.purchases.create') ? 'active':''}}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Buy Package For user</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{route('dashboard.purchases.create')}}" class="nav-link {{ Route::is('dashboard.packages.index') ? 'active':''}}">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>Buy Package For user</p>
                        </a>
                    </li>
                @endrole
                    <li class="nav-item">
                        <a href="{{route('dashboard.purchases.index')}}" class="nav-link  {{ Route::is('dashboard.purchases.index') || Route::is('dashboard.') ? 'active':''}}">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Purchase History</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('dashboard.account.index')}}" class="nav-link  {{ Route::is('dashboard.account.index') ? 'active':''}}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Account Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="$('#logout-form').submit();"  class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</div>
