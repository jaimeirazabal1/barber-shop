<!-- Main Sidebar -->
<div id="sidebar">
    <!-- Sidebar Brand -->
    <div id="sidebar-brand" class="themed-background">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-title">
            <i class="fa fa-scissors"></i> <span class="sidebar-nav-mini-hide"><strong>{{ Session::get('company')->name }}</strong></span>
        </a>
    </div>
    <!-- END Sidebar Brand -->

    <!-- Wrapper for scrolling functionality -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">

            <!--figure class="text-center">
                {{ HTML::image('assets/admin/img/logo-medium.jpg', '', array('class' => 'img-responsive')) }}
            </figure-->

            <!-- Sidebar Navigation -->
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class=""><i class="gi gi-compass sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                </li>

                <li class="sidebar-separator">
                    <i class="fa fa-ellipsis-h"></i>
                </li>


                {{-- CITAS --}}
                <li>
                    <a href="" class=""><i class="fa fa-calendar sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Citas</span></a>
                </li>

                <li class="sidebar-separator">
                    <i class="fa fa-ellipsis-h"></i>
                </li>


                {{-- Clientes --}}
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Clientes</span></a>
                    <ul>
                        <li>
                            <a href="">Ver listado</a>
                        </li>
                        <li>
                            <a href="">Agregar nuevo</a>
                        </li>
                    </ul>
                </li>


                {{-- Barberos --}}
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-scissors sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Barberos</span></a>
                    <ul>
                        <li>
                            <a href="">Ver listado</a>
                        </li>
                        <li>
                            <a href="">Agregar nuevo</a>
                        </li>
                    </ul>
                </li>



                {{-- Productos --}}
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cubes sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Productos</span></a>
                    <ul>
                        <li>
                            <a href="">Ver listado</a>
                        </li>
                        <li>
                            <a href="">Agregar nuevo</a>
                        </li>
                    </ul>
                </li>

                {{-- Proveedores --}}
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-truck sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Proveedores</span></a>
                    <ul>
                        <li>
                            <a href="">Ver listado</a>
                        </li>
                        <li>
                            <a href="">Agregar nuevo</a>
                        </li>
                    </ul>
                </li>

                {{-- Sucursales --}}
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-home sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Sucursales</span></a>
                    <ul>
                        <li>
                            <a href="">Ver listado</a>
                        </li>
                        <li>
                            <a href="">Agregar nueva</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-separator">
                    <i class="fa fa-ellipsis-h"></i>
                </li>

                {{-- USERS --}}
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-users sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Usuarios</span></a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.users.index') }}">Ver listado</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.create') }}">Agregar nuevo</a>
                        </li>
                    </ul>
                </li>
                <!--li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-rocket sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">User Interface</span></a>
                    <ul>
                        <li>
                            <a href="page_ui_widgets.html">Widgets</a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Elements</a>
                            <ul>
                                <li>
                                    <a href="page_ui_blocks_grid.html">Blocks &amp; Grid</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li-->
                <li class="sidebar-separator">
                    <i class="fa fa-ellipsis-h"></i>
                </li>
            </ul>
            <!-- END Sidebar Navigation -->


        </div>
        <!-- END Sidebar Content -->
    </div>
    <!-- END Wrapper for scrolling functionality -->

    <!-- Sidebar Extra Info -->
    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
        <div class="text-center">
            <small>Desarrollador por <a href="http://desarrollo.mx" target="_blank">Empresa</a></small><br>
            <small>{{ date('Y') }} &copy; <a href="http://barbershopmn.com" target="_blank">barbershopmn.com</a></small>
        </div>
    </div>
    <!-- END Sidebar Extra Info -->
</div>
<!-- END Main Sidebar -->