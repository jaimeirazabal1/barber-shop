<header class="navbar navbar-inverse navbar-fixed-top">
    <!-- Left Header Navigation -->
    <ul class="nav navbar-nav-custom">
        <!-- Main Sidebar Toggle Button -->
        <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
            </a>
        </li>
        <!-- END Main Sidebar Toggle Button -->

        <!-- Header Link -->
        <li class="hidden-xs animation-fadeInQuick">
            <a href=""><strong class="text-uppercase">@yield('title', '')</strong></a>
        </li>
        <!-- END Header Link -->
    </ul>
    <!-- END Left Header Navigation -->

    <!-- Right Header Navigation -->
    <ul class="nav navbar-nav-custom pull-right">
        <!-- Search Form -->
        <!--li>
            <form action="page_ready_search_results.html" method="post" class="navbar-form-custom" role="search">
                <input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search..">
            </form>
        </li-->
        <!-- END Search Form -->


        <!-- User Dropdown -->
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user fa-3x"></i> {{ $composer_user->first_name }} {{ $composer_user->last_name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <!--li class="dropdown-header">
                    <strong>ADMINISTRADOR</strong>
                </li>
                <li>
                    <a href="page_app_email.html">
                        <i class="fa fa-inbox fa-fw pull-right"></i>
                        Mensajes de entrada
                    </a>
                </li>
                <li>
                    <a href="page_app_social.html">
                        <i class="fa fa-pencil-square fa-fw pull-right"></i>
                        Perfil
                    </a>
                </li>
                <li class="divider"><li>
                <li>
                    <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');">
                        <i class="gi gi-settings fa-fw pull-right"></i>
                        Configuración
                    </a>
                </li>
                <li>
                    <a href="page_ready_lock_screen.html">
                        <i class="gi gi-lock fa-fw pull-right"></i>
                        Bloquear Cuenta
                    </a>
                </li>
                <li>
                    <a href="page_ready_login.html">
                        <i class="fa fa-power-off fa-fw pull-right"></i>
                        Cerrar sesión
                    </a>
                </li-->
                <li>
                    <a href="{{ route('sessions.destroy', $company) }}">
                        <i class="fa fa-power-off fa-fw pull-right"></i>
                        Cerrar sesión
                    </a>
                </li>
            </ul>
        </li>
        <!-- END User Dropdown -->
    </ul>
    <!-- END Right Header Navigation -->
</header>
<!-- END Header -->