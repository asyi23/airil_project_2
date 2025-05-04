<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon-biscard.ico')}}">
    @include('layouts.head')
</head>

@section('body')
@show

<body data-sidebar="dark">
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
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">

                <div class="container-fluid">
                    @if(Session::has('success_msg'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {!! Session::get('success_msg') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                    @if(Session::has('fail_msg'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ Session::get('fail_msg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    {{-- @include('layouts.right-sidebar') --}}
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    @include('layouts.footer-script')
    <script>
        $('.select2').select2({
            width: '100%',
        });

        function check_select_active() {
            $(".select_active").each(function () {
                if (this.value) {
                    this.style.borderColor = "#31acbf";
                } else {
                    this.style.borderColor = "";
                }
            });

            $(".select2_active").each(function () {
                if (this.value) {
                    $(this).data('select2').$selection.css("border-color", "#31acbf");
                } else {
                    $(this).data('select2').$selection.css("border-color", "");
                }
            });
        }

        check_select_active();

        $('.select_active').on('change', check_select_active);
        $('.select2_active').on('change', check_select_active);
    </script>
</body>

</html>
