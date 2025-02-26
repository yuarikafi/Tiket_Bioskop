<nav
    class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="collapse navbar-collapse show" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                            href="#"><i class="ft-menu"></i></a></li>
                    <li class="nav-item dropdown navbar-search"><a class="nav-link dropdown-toggle hide"
                            data-toggle="dropdown" href="#"><i class="ficon ft-search"></i></a>
                        <ul class="dropdown-menu">
                            <li class="arrow_box">
                                <form>
                                    <div class="input-group search-box">
                                        <div class="position-relative has-icon-right full-width">
                                            <input class="form-control" id="search" type="text"
                                                placeholder="Search here...">
                                            <div class="form-control-position navbar-search-close"><i class="ft-x">
                                                </i></div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->


<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true"
    data-img="theme-assets/images/backgrounds/02.jpg">
    <div class="navbar-header text-center w-100">
        <ul class="nav navbar-nav justify-content-center flex-row w-100">
            <li class="nav-item">
                <img class="brand-logo" alt="Chameleon admin logo" src="../img/cinema.jpg"
                    style="width: 190px; height: auto; position: relative; top: -70px;" />

            </li>
        </ul>
    </div>

    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            ?>

            <li class="<?= ($current_page == 'admin.php') ? 'active' : '' ?>">
                <a href="admin.php"><i class="ft-home"></i><span class="menu-title">Dashboard</span></a>
            </li>
            <li class="nav-item <?= ($current_page == 'akun_admin.php') ? 'active' : '' ?>">
                <a href="akun_admin.php"><i class="ft-user"></i><span class="menu-title">Akun Admin</span></a>
            </li>
            <li class="nav-item <?= ($current_page == 'akun_mall.php') ? 'active' : '' ?>">
                <a href="akun_mall.php"><i class="ft-shopping-cart"></i><span class="menu-title">Akun Mall</span></a>
            </li>
            <li class="nav-item <?= ($current_page == 'jadwal_film.php') ? 'active' : '' ?>">
                <a href="jadwal_film.php"><i class="ft-calendar"></i><span class="menu-title">Jadwal Film</span></a>
            </li>
            <li class="nav-item <?= ($current_page == 'data_film.php') ? 'active' : '' ?>">
                <a href="data_film.php"><i class="ft-film"></i><span class="menu-title">Data Film</span></a>
            </li>
            <li class="nav-item <?= ($current_page == 'riwayat.php') ? 'active' : '' ?>">
                <a href="riwayat.php"><i class="ft-clock"></i><span class="menu-title">History Pembelian</span></a>
            </li>
        </ul>
    </div>


    <div class="navigation-background"></div>
</div>