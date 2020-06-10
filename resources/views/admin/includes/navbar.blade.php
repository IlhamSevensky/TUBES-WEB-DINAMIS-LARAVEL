<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>P</b>S</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Plant </b>Shop</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ auth()->user()->getAvatar() }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ auth()->user()->getAvatar() }}" class="img-circle" alt="User Image">

                            <p>
                                {{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}
                                <small>Member since {{ date('M. Y', strtotime(auth()->user()->created_at)) }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            {{-- <div class="pull-left">
                                <a href="#profile" data-toggle="modal" class="btn btn-default" id="admin_profile">Update</a>
                            </div> --}}
                            <div class="pull-right">
                                <a href="/logout" class="btn btn-default">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
@include('admin.includes.profile_modal')
