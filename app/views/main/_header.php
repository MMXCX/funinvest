<!--Main Navigation-->
<header>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
        <a class="navbar-brand" href="/"><strong>Главная</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/terms">Правила</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Контакты</a>
                </li>
            </ul>
            <ul class="nav navbar-nav nav-flex ml-auto">
<?php if (isset($_SESSION['account']['user'])) : ?>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/panel"><i class="fal fa-keynote"></i><span
                                class="clearfix d-sm-inline-block">Панель управления</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/logout"><i class="fal fa-sign-out-alt"></i><span
                                class="clearfix d-sm-inline-block">Выход</span></a>
                </li>
<?php else : ?>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/login"><i class="fal fa-sign-in-alt"></i><span
                                class="clearfix d-sm-inline-block">Вход</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/register"><i class="fal fa-user-plus"></i><span
                                class="clearfix d-sm-inline-block">Регистрация</span></a>
                </li>
<?php endif ?>
            </ul>
        </div>
    </nav>

    <div class="view intro-2" style="">
        <div class="full-bg-img">
            <div class="mask rgba-purple-light flex-center">
                <div class="container text-center white-text wow fadeInUp">
                    <h2>This Navbar is fixed and transparent</h2>
                    <br>
                    <h5>It will always stay visible on the top, even when you scroll down</h5>
                    <p>Navbar's background will switch from transparent to solid color while scrolling down</p>
                    <br>
                    <p>Full page intro with background image will be always displayed in full screen mode, regardless of
                        device </p>
                </div>
            </div>
        </div>
    </div>

</header>
<!--Main Navigation-->
