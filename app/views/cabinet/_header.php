<!--Double navigation-->
<header>
    <!-- Sidebar navigation -->
    <div id="slide-out" class="side-nav sn-bg-1 fixed">
        <ul class="custom-scrollbar">
            <!-- Logo -->
            <li>
                <div class="logo-wrapper waves-light">
                    <a href="/panel"><img src="/img/mdb/mdb-transparent.png"
                                     class="img-fluid flex-center"></a>
                </div>
            </li>
            <!--/. Logo -->
            <!--Social-->
            <li>
                <ul class="social">
                    <li><a href="#" class="icons-sm fb-ic"><i class="fab fa-facebook-f"> </i></a></li>
                    <li><a href="#" class="icons-sm pin-ic"><i class="fab fa-pinterest"> </i></a></li>
                    <li><a href="#" class="icons-sm gplus-ic"><i class="fab fa-google-plus-g"> </i></a></li>
                    <li><a href="#" class="icons-sm tw-ic"><i class="fab fa-twitter"> </i></a></li>
                </ul>
            </li>
            <!--/Social-->
            <!-- Side navigation links -->
            <li>
                <ul class="collapsible collapsible-accordion">
                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-chevron-right"></i> Submit
                            blog<i class="fas fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#" class="waves-effect">Submit listing</a>
                                </li>
                                <li><a href="#" class="waves-effect">Registration form</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <hr>
                    <li>
                        <a class="waves-effect" href="/deposit">
                            <i class="fas fa-piggy-bank"></i>Пополнить
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect" href="/payout">
                            <i class="fas fa-envelope-open-dollar"></i>Выплаты
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a class="waves-effect" href="/settings">
                            <i class="fas fa-cog"></i>Настройки
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a class="waves-effect" href="/about">
                            <i class="fas fa-eye"></i>О нас
                        </a>
                    </li>
                </ul>
            </li>
            <!--/. Side navigation links -->
        </ul>
        <div class="sidenav-bg mask-strong"></div>
    </div>
    <!--/. Sidebar navigation -->
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
        <!-- SideNav slide-out button -->
        <div class="float-left">
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
        </div>
        <!-- Breadcrumb-->
        <div class="breadcrumb-dn mr-auto">
            <p>Material Design for Bootstrap</p>
        </div>
        <ul class="nav navbar-nav nav-flex-icons ml-auto">





            <li class="nav-item">
                <a class="btn btn-sm btn-so">
                    <i class="fas fa-envelope"></i>
                </a>
                <span class="counter counter-sm">12</span>
            </li>






            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fas fa-user"></i> <span
                            class="clearfix d-none d-sm-inline-block">Аккаунт</span></a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/settings">Настройки</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="/logout" type="button" class="btn btn-outline-info btn-rounded btn-sm waves-effect"><i
                            class="fas fa-sign-out-alt pr-2"
                            aria-hidden="true"></i>Выйти
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.Navbar -->
</header>
<!--/.Double navigation-->