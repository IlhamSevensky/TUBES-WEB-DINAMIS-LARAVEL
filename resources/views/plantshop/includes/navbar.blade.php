{{-- Start Navbar --}}
<header class="main-header">
    <nav class="navbar navbar-static-top bg-green">
        <div class="container">
            <div class="navbar-header">
                <a href="/" class="navbar-brand"><b>Plant </b>Shop</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">HOME</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">CATEGORY <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($navbar_category as $item)
                            <li>
                                <a href="/category/{{ $item->cat_slug }}">{{ $item->name }}</a>
                            </li>
                            @endforeach

                        </ul>
                    </li>
                </ul>
                <form method="GET" class="navbar-form navbar-left" action="/search">
                    <div class="input-group">
                        <input type="text" class="form-control" id="navbar-search-input" name="keyword" placeholder="Search for Product" required>
                        <span class="input-group-btn" id="searchBtn" style="display:none;">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> </button>
                        </span>
                    </div>
                </form>
            </div>
            <!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="label label-danger cart_count"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have <span class="cart_count"></span> item(s) in cart</li>
                            <li>
                                <ul class="menu" id="cart_menu">
                                </ul>
                            </li>
                            <li class="footer"><a href="{{ route('cart_page') }}">Go to Cart</a></li>
                        </ul>
                    </li>
                    @if(session()->has('session'))
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ auth()->user()->getAvatar() }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-green">
                                <img src="{{ auth()->user()->getAvatar() }}" class="img-circle" alt="User Image">
                                <p> {{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}
                                    <small>Member since {{ date('M. Y', strtotime(auth()->user()->created_at)) }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/profile" class="btn btn-default">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/logout" class="btn btn-default">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('login_page') }}">LOGIN</a>
                    </li>
                    <li>
                        <a href="{{ route('register_page') }}">SIGNUP</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
{{-- End Navbar --}}
