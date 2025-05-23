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
                <a href="{{ route('vendors.home') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::dashboard.index.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.control') }}</h3>
            </li>

            @if(is_null(auth()->guard('vendor')->user()->parent_id))
            <li class="nav-item {{ active_menu('staff') }}">
                <a href="{{ url(route('vendors.staff.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.vendors_menu.staff') }}</span>
                    <span class="selected"></span>
                </a>
            </li>
            @endif

            <li class="nav-item  {{ active_slide_menu(['clients']) }} open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside._tabs.clients') }}</span>
                    <span class="arrow {{ active_slide_menu(['cars']) }} open"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: block">
                    {{-- <li class="nav-item {{ active_menu('clients') }}">
                        <a href="{{ url(route('vendors.users.create')) }}" class="nav-link nav-toggle">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.add_clients') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li> --}}
                    <li class="nav-item {{ active_menu('clients') }}">
                        <a href="{{ url(route('vendors.users.index')) }}" class="nav-link nav-toggle">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.view_clients') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item  {{ active_slide_menu(['cars']) }} open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-car"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside._tabs.cars') }}</span>
                    <span class="arrow {{ active_slide_menu(['cars']) }} open"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: block">
                    <li class="nav-item {{ active_menu('cars') }}">
                        <a href="{{ url(route('vendors.cars.create')) }}" class="nav-link nav-toggle">
                            <i class="fa fa-plus"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside._tabs.add_car') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item {{ active_menu('cars') }}">
                        <a href="{{ url(route('vendors.cars.index')) }}" class="nav-link nav-toggle">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.my_cars') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item {{ active_menu('cars') }}">
                        <a href="{{ url(route('vendors.cars.find')) }}" class="nav-link nav-toggle">
                            <i class="fa fa-search"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.find_cars') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</div>
