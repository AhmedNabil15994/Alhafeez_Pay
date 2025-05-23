<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ is_rtl() }}">

    @if (is_rtl() == 'rtl')
      @include('apps::frontend.layouts._head_rtl')
    @else
      @include('apps::frontend.layouts._head_ltr')
    @endif

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">

            @include('apps::frontend.layouts._header')

            <div class="clearfix"> </div>

            <div class="page-container">
                @include('apps::frontend.layouts._aside')

                @yield('content')
            </div>

            @include('apps::frontend.layouts._footer')
        </div>

        @include('apps::frontend.layouts._jquery')
        @include('apps::frontend.layouts._js')
    </body>
</html>
