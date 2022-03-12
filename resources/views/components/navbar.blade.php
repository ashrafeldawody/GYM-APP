<div>
    <nav class="main-header navbar navbar-expand navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ Auth::user()->avatar }}" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image">

                        <p>
                            {{ auth()->user()->name }}
                            <small>
                                @hasrole('gym_manager')
                                Gym Manager
                                @endrole
                                @hasrole('city_manager')
                                City Manager
                                @endrole
                                @hasrole('admin')
                                Administrator
                                @endrole
                            </small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{route('dashboard.account.index')}}" class="btn btn-default btn-flat">Settings</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="$('#logout-form').submit();" class="btn btn-default btn-flat float-right">Sign out</a>
                    </li>
                </ul>
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
