<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo">
                <a href="index.html" class="logo"><i class="fa fa-server"></i> <span>{{ config('app.name', 'Laravel') }}</span> </a>
</div>
<!-- End Logo container-->

<div class="menu-extras">

    <ul class="nav navbar-nav navbar-right pull-right">

        @include('partials.nav-profile')

    </ul>

    <div class="menu-item">
        <!-- Mobile menu toggle-->
        <a class="navbar-toggle">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
        <!-- End mobile menu toggle-->
    </div>
</div>

</div>
</div>
<!-- End topbar -->


<!-- Navbar Start -->
<div class="navbar-custom">
    <div class="container">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="/home"><i class="md md-home"></i>Home</a>
                </li>

                <li class="has-submenu">
                    <a href="/admin/servers"><i class="fa fa-server"></i>Servers</a>
                </li>

                <li class="has-submenu">
                    <a href="/admin/users"><i class="fa fa-users"></i>Users</a>
                </li>

                <li class="has-submenu">
                    <a href="/admin/nodes"><i class="fa fa-sitemap"></i>Nodes</a>
                </li>

                <li class="has-submenu">
                    <a href="/admin/templates"><i class="fa fa-file"></i>Templates</a>
                </li>


            </ul>
            <!-- End navigation menu -->
        </div> <!-- end #navigation -->
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->