<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ auth()->user()->getAvatar() }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</p>
                <a><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">REPORTS</li>
            <li><a href="/admin/month/{{$year_now}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li><a href="/admin/sales"><i class="fa fa-money"></i> <span>Sales</span></a></li>
            <li class="header">MANAGE</li>
            <li><a href="/admin/users"><i class="fa fa-users"></i> <span>Users</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-barcode"></i>
                    <span>Products</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/products/all"><i class="fa fa-circle-o"></i> Product List</a></li>
                    <li><a href="/admin/category"><i class="fa fa-circle-o"></i> Category</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
