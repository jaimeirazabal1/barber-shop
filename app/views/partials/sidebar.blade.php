<!-- Main Sidebar -->
<div id="sidebar">
    <!-- Sidebar Brand -->
    <div id="sidebar-brand" class="themed-background">
        <a href="{{ route('app.dashboard') }}" class="sidebar-title">
            <span class="sidebar-nav-mini-hide">{{ $composer_company->name }}</span>
        </a>
    </div>
    <!-- END Sidebar Brand -->

    <!-- Wrapper for scrolling functionality -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">

            <figure class="text-center">
                {{ HTML::image('assets/admin/img/logo-inter.jpg', $composer_company->name, array('class' => 'img-responsive', 'style' => 'margin: 20px auto 0 auto;')) }}
            </figure>

            <!-- Sidebar Navigation -->
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('app.dashboard', array($company)) }}" class=""><i class="gi gi-compass sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                </li>
                <li class="sidebar-separator">
                    <i class="fa fa-ellipsis-h"></i>
                </li>
                @if( $composer_user->hasAnyAccess(['admin', 'company']) )
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-scissors sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Barberos</span></a>
                    <ul>
                        <li>
                            <a href="{{ route('barbers.create', $company) }}">Agregar barbero</a>
                        </li>
                        <li>
                            <a href="{{ route('barbers.index', $company) }}">Ver todos</a>
                        </li>
                    </ul>
                </li>
                @endif
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-calendar sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Citas</span></a>

                    <ul>
                        @foreach($composer_stores as $composer_store)
                            {{-- Muestra la sucursal asignada para el usuario Sucursal--}}
                            @if ( $composer_user->hasAccess('store') )
                                @if ($composer_store->user_id == $composer_user->id)
                                    <li>
                                        <a href="{{ route('appointments.index', [$company, 'store' => $composer_store->id]) }}">{{ $composer_store->name }}</a>
                                    </li>
                                @endif
                            @elseif( $composer_user->hasAnyAccess(['admin', 'company']) )
                            {{-- Muestra todas las sucursales para admin y company --}}
                            <li>
                                <a href="{{ route('appointments.index', [$company, 'store' => $composer_store->id]) }}">{{ $composer_store->name }}</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                @if( $composer_user->hasAnyAccess(['admin', 'company', 'store']) )
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-users sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Clientes</span></a>
                    <ul>
                        <li>
                            <a href="{{ route('customers.create', $company) }}">Agregar cliente</a>
                        </li>
                        <li>
                            <a href="{{ route('customers.index', $company) }}">Ver todos</a>
                        </li>
                    </ul>
                </li>
                @endif

                @if( $composer_user->hasAnyAccess(['admin', 'company']) )
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cubes sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Productos</span></a>
                    <ul>
                        <li>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Categorías</a>
                            <ul>
                                <li>
                                    {{ link_to_route('category-products.create', 'Agregar categoría', $company) }}
                                </li>
                                <li>
                                    {{ link_to_route('category-products.index', 'Ver Todos', $company) }}
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Tags</a>
                            <ul>
                                <li>
                                    {{ link_to_route('tag-products.create', 'Agregar Tag', $company) }}
                                </li>
                                <li>
                                    {{ link_to_route('tag-products.index', 'Ver Todos', $company) }}
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Productos</a>
                            <ul>
                                <li>
                                    {{ link_to_route('products.create', 'Agregar Producto', $company) }}
                                </li>
                                <li>
                                    {{ link_to_route('products.index', 'Ver Todos', $company) }}
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif

                @if( $composer_user->hasAnyAccess(['admin', 'company']) )
                <li>
                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-truck sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Proveedores</span></a>
                    <ul>
                        <li>
                            {{ link_to_route('suppliers.create', 'Agregar Proveedor', $company) }}
                        </li>
                        <li>
                            {{ link_to_route('suppliers.index', 'Ver Todos', $company) }}
                        </li>
                    </ul>
                </li>
                @endif

                @if( $composer_user->hasAnyAccess(['admin', 'company']) )
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cogs sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Servicios</span></a>
                    <ul>
                        <li>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Categorías</a>
                            <ul>
                                <li>
                                    {{ link_to_route('category-services.create', 'Agregar categoría', $company) }}
                                </li>
                                <li>
                                    {{ link_to_route('category-services.index', 'Ver Todos', $company) }}
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Tags</a>
                            <ul>
                                <li>
                                    {{ link_to_route('tag-services.create', 'Agregar Tag', $company) }}
                                </li>
                                <li>
                                    {{ link_to_route('tag-services.index', 'Ver Todos', $company) }}
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Servicios</a>
                            <ul>
                                <li>
                                    {{ link_to_route('services.create', 'Agregar Servicio', $company) }}
                                </li>
                                <li>
                                    {{ link_to_route('services.index', 'Ver Todos', $company) }}
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif


                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-home sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Sucursales</span></a>
                    <ul>
                        @if( $composer_user->hasAnyAccess(['admin', 'company']) )
                        <li>
                            <a href="{{ route('stores.create', $company) }}">Agregar sucursal</a>
                        </li>
                        <li>
                            <a href="{{ route('stores.index', $company) }}">Ver todas</a>
                        </li>
                        <li class="sidebar-separator">
                            <i class="fa fa-ellipsis-h"></i>
                        </li>
                        @endif
                        @foreach($composer_stores as $composer_store)
                            {{-- Muestra la sucursal asignada para el usuario Sucursal--}}
                            @if ( $composer_user->hasAccess('store') )
                                @if ($composer_store->user_id == $composer_user->id)
                                <li>
                                    <a href="{{ route('stores.edit', [$company, $composer_store->id]) }}">{{ $composer_store->name }}</a>
                                </li>
                                @endif
                            @elseif( $composer_user->hasAnyAccess(['admin', 'company']) )
                                {{-- Muestra todas las sucursales para admin y company --}}
                                <li>
                                    <a href="{{ route('stores.edit', [$company, 'store' => $composer_store->id]) }}">{{ $composer_store->name }}</a>
                                </li>
                            @endif
                        @endforeach
                            @if( $composer_user->hasAnyAccess(['admin', 'company']) )
                                <li class="sidebar-separator">
                                    <i class="fa fa-ellipsis-h"></i>
                                </li>
                            @endif
                    </ul>
                </li>
                <li><!-- ventas por sucursal -->
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-shopping-cart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Ventas</span></a>
                    <ul>
                        <!--li>
                            <a href="{{ route('sales.index', $company) }}">Generales</a>
                        </li-->


                        @foreach($composer_stores as $composer_store)
                            {{-- Muestra la sucursal asignada para el usuario Sucursal--}}
                            @if ( $composer_user->hasAccess('store') )
                                @if ($composer_store->user_id == $composer_user->id)


                                    <li>
                                        <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>{{ $composer_store->name }}</a>
                                        <ul>

                                            <li>
                                                <a href="{{ route('sales.index', [$company, 'store' => $composer_store->id]) }}">Ventas</a>
                                            </li>
                                            <!--li class="sidebar-separator">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </li-->
                                            <li>
                                                <a href="{{ route('cashout.index', [$company, 'store' => $composer_store->id]) }}">Corte de caja</a>
                                            </li>

                                        </ul>
                                    </li>

                                @endif
                            @elseif( $composer_user->hasAnyAccess(['admin', 'company']) )
                                {{-- Muestra todas las sucursales para admin y company --}}

                                <li>
                                    <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>{{ $composer_store->name }}</a>
                                    <ul>

                                        <li>
                                            <a href="{{ route('sales.index', [$company, 'store' => $composer_store->id]) }}">Ventas</a>
                                        </li>
                                        <!--li class="sidebar-separator">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </li-->
                                        <li>
                                            <a href="{{ route('cashout.index', [$company, 'store' => $composer_store->id]) }}">Corte de caja</a>
                                        </li>

                                    </ul>
                                </li>

                            @endif
                        @endforeach

                        <li>
                            <a href="{{ route('payroll.index', [$company]) }}">Nómina</a>
                        </li>

                    </ul>
                </li>

                @if( $composer_user->hasAnyAccess(['admin', 'company']) )
                <li class="sidebar-separator">
                    <i class="fa fa-ellipsis-h"></i>
                </li>
                <li>
                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Usuarios</span></a>
                    <ul>

                        <li>
                            <a href="{{ route('users.create', $company) }}">Agregar usuario</a>
                        </li>
                        <li>
                            <a href="{{ route('users.index', $company) }}">Ver todos</a>
                        </li>
                    </ul>
                </li>
                @endif


                @if( $composer_user->hasAnyAccess(['company']) )
                    <li class="sidebar-separator">
                        <i class="fa fa-ellipsis-h"></i>
                    </li>
                    <li>
                        <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-bar-chart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Reportes</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('reports.generate', $company) }}">Generar</a>
                            </li>
                            {{--<li>--}}
                                {{--<a href="{{ route('reports.numero-clientes-atendidos', $company) }}">Núm. clientes atendidos</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('reports.servicios-por-dia', $company) }}">Servicios por día</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('reports.importe-de-ventas-de-servicios', $company) }}">Importe de ventas de servicios</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('reports.importe-de-ventas-de-productos', $company) }}">Importe de ventas de productos</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('reports.productos-mas-vendidos', $company) }}">Productos más vendidos</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('reports.tiempo-promedio-por-servicio', $company) }}">Tiempo promedio de servicios</a>--}}
                            {{--</li>--}}
                        </ul>
                    </li>
                @endif

            </ul>
            <!-- END Sidebar Navigation -->


        </div>
        <!-- END Sidebar Content -->
    </div>
    <!-- END Wrapper for scrolling functionality -->

    <!-- Sidebar Extra Info -->
    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">

        <div class="text-center">
            <small><a href="http://barbershopmn.com" target="_blank" class="text-info">{{ $composer_company->name }}</a></small><br>
            <small>{{ date('Y') }} &copy; <a href="http://ascmexico.com.mx/" target="_blank" class="text-muted">ascmexico.com.mx</a></small>
        </div>
    </div>
    <!-- END Sidebar Extra Info -->
</div>
<!-- END Main Sidebar -->