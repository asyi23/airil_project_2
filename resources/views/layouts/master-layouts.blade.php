<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | {{config('app.name')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/Biscard Favicon.png')')}}">
        @include('layouts.head')
    </head>

    @yield('body')
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.top-hor')
        @include('layouts.hor-menu')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <!-- Start content -->
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('layouts.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- END Right Sidebar -->

    @include('layouts.footer-script')
    </body>
</html>
