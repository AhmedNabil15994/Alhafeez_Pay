<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ is_rtl() }}">

    @if (is_rtl() == 'rtl')
      @include('apps::dashboard.layouts._head_rtl')
    @else
      @include('apps::dashboard.layouts._head_ltr')
    @endif

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md" style="background: white">
        <div class="page-wrapper">

            <div class="clearfix"> </div>

            <div class="page-container">
                <div style="margin: 0 auto; max-width: 70%">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
