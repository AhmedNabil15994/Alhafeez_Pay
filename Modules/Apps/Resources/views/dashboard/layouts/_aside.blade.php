<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">

            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <li class="nav-item {{ active_menu('home') }}">
                <a href="{{ url(route('dashboard.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::dashboard.index.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.control') }}</h3>
            </li>

            @can('show_roles')
                <li class="nav-item {{ active_menu('roles') }}">
                    <a href="{{ url(route('dashboard.roles.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-briefcase"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.roles') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan


            @can('show_admins')
                <li class="nav-item {{ active_menu('admins') }}">
                    <a href="{{ url(route('dashboard.admins.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-users"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.admins') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan

            @canany(['show_invoices'])
            <li class="nav-item {{ active_menu('invoices') }}">
                <a href="{{ url(route('dashboard.invoices.index')) }}" class="nav-link nav-toggle">
                    <i class="fa fa-dollar"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside._tabs.invoices') }}</span>
                    <span class="selected"></span>
                </a>
            </li>

            @endcanAny

            {{-- @canany(['show_countries'])
                <li class="nav-item  {{ active_slide_menu(['countries']) }} open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-pointer"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.countries_nationalities') }}</span>
                        <span
                            class="arrow {{ active_slide_menu(['countries']) }} open"></span>
                        <span class="selected"></span>
                    </a>
                    <ul class="sub-menu" style="display: block">
                        <li class="nav-item {{ active_menu('countries') }}">
                            <a href="{{ url(route('dashboard.countries.index')) }}" class="nav-link nav-toggle">
                                <i class="fa fa-dot-circle-o"></i>
                                <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @canany(['show_areas', 'show_cities', 'show_states'])
                <li class="nav-item  {{ active_slide_menu(['cities', 'states', 'areas']) }} open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-pointer"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.areas') }}</span>
                        <span
                            class="arrow {{ active_slide_menu(['governorates', 'cities', 'regions']) }} open"></span>
                        <span class="selected"></span>
                    </a>
                    <ul class="sub-menu" style="display: block">
                        @can('show_cities')
                            <li class="nav-item {{ active_menu('cities') }}">
                                <a href="{{ url(route('dashboard.cities.index')) }}" class="nav-link nav-toggle">
                                    <i class="fa fa-dot-circle-o"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.cities') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan

                        @can('show_states')
                            <li class="nav-item {{ active_menu('states') }}">
                                <a href="{{ url(route('dashboard.states.index')) }}" class="nav-link nav-toggle">
                                    <i class="fa fa-dot-circle-o"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.state') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanAny --}}

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.other') }}</h3>
            </li>

            @can('show_pages')
                <li class="nav-item {{ active_menu('pages') }}">
                    <a href="{{ url(route('dashboard.pages.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-docs"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.pages') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan

            @can('show_sliders')
                <li class="nav-item {{ active_menu('sliders') }}">
                    <a href="{{ url(route('dashboard.sliders.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-docs"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.sliders') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan

            @can('edit_settings')
                <li class="nav-item {{ active_menu('setting') }}">
                    <a href="{{ url(route('dashboard.setting.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.setting') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan

            @can('show_logs')
                <li class="nav-item {{ active_menu('logs') }}">
                    <a href="{{ url(route('dashboard.logs.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-folder"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.logs') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan

        </ul>
    </div>

</div>
