<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('')}}assets/images/Biscard Favicon.png" alt="" height="25">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('')}}assets/images/airil_logo.jpeg" alt="" height="60" width="170" style="margin-top: 10px;">
                    </span>
                </a>

                <a href="{{ route('dashboard')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('')}}assets/images/Biscard Favicon.png" alt="" height="25">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('')}}assets/images/airil_logo.jpeg" alt="" height="60" width="170" style="margin-top: 10px;">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (Auth::user()->hasMedia('user_profile_picture'))
                    <img class="rounded-circle header-profile-user" src="{{Auth::user()->getFirstMediaUrl('user_profile_picture')}}" height="50" />
                    @else
                    <img class="rounded-circle header-profile-user" src="{{url('assets/images/users/avatar-1.jpg')}}" height="50" />
                    @endif

                    <span class="d-none d-xl-inline-block ml-1 va_top">
                        <span>{{{ ucfirst(Auth::user()->user_fullname)  }}}</span><br />
                        <span><small>{{ isset(AUTH::user()->roles[0]) ? AUTH::user()->roles[0]->name: "" }}</small></span>
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    @if (Auth::user()->user_type_id == '1')
                    <a class="dropdown-item" href="{{ route('admin_profile') }}"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                    <a class="dropdown-item d-block" href="{{ route('admin_change_password') }}"><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> Change Password</a>
                    @else
                    <a class="dropdown-item" href="{{ route('user_profile') }}"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                    <a class="dropdown-item d-block" href="{{ route('user_change_password') }}"><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> Change Password</a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> {{ __('Logout') }} </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>