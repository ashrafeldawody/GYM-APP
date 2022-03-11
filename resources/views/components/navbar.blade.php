<div>
    <nav class="main-header navbar navbar-expand navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="card card-widget widget-user-2 shadow-sm">

                        <div class="widget-user-header">
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src="{{asset(Auth::user()->avatar ? url(URL::to('/') . '/'. Auth::user()->avatar) : '/dist/img/avatar.png')}}" alt="User Avatar">
                            </div>

                            <h3 class="widget-user-username h5">{{ auth()->user()->name }}</h3>

                            <h5 class="widget-user-desc">
                                @hasrole('gym_manager')
                                Gym Manager
                                @endrole
                                @hasrole('city_manager')
                                City Manager
                                @endrole
                                @hasrole('admin')
                                Administrator
                                @endrole
                            </h5>
                        </div>
                        <div class="card-footer p-0">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="{{route('dashboard.account.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-cog"></i>
                                        Account Settings
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a href="#" onclick="$('#logout-form').submit();"  class="nav-link">
                                        <i class="nav-icon fas fa-sign-out-alt"></i>
                                        Logout
                                    </a>


                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <div class="custom-control custom-switch custom-switch-xl">
                    <label class="theme-switch" for="checkbox">
                        <input id="darkmode" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="darkmode"></label>

                    </label>
                </div>
            </li>
        </ul>
    </nav>
</div>
