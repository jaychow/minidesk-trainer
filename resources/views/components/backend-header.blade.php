<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
        <div class="navbar-header">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand"><b>Trad</b>ING</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('admin-crud') }}">Admin</a></li>
                <li><a href="{{ route('data-import') }}">Import</a></li>
                <li><a href="{{ route('trend') }}">Trend</a></li>
                <li><a href="{{ route('admin-crud') }}">Settings</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="{{ asset('dist/img/avatar5.png') }}" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">{{ Auth::user()->name }} </span>
                </a>
                <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                    <img src="{{ asset('dist/img/avatar5.png') }}" class="img-circle" alt="User Image">

                    <p>
                    {{ Auth::user()->name }}  - Web Developer
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Sign out') }}
                    </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                </ul>
            </li>
            </ul>
        </div>
        <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>
