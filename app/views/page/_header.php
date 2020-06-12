<!--Main Navigation-->
<header>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark special-color-dark scrolling-navbar">
        <a class="navbar-brand" href="/"><strong>Главная</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item<?= $action == 'terms' ? ' active' : '' ?>">
                    <a class="nav-link" href="/terms">Правила</a>
                </li>
                <li class="nav-item<?= $action == 'about' ? ' active' : '' ?>">
                    <a class="nav-link" href="/about">О нас</a>
                </li>
                <li class="nav-item<?= $action == 'contact' ? ' active' : '' ?>">
                    <a class="nav-link" href="/contact">Контакты</a>
                </li>
            </ul>
            <ul class="nav navbar-nav nav-flex ml-auto">
<?php if (isset($_SESSION['account']['user'])) : ?>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/logout"><i class="fal fa-sign-out-alt"></i> <span
                                class="clearfix d-sm-inline-block">Выход</span></a>
                </li>
<?php else : ?>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/login"><i class="fal fa-sign-in-alt"></i> <span
                                class="clearfix d-sm-inline-block">Вход</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/register"><i class="fal fa-user-plus"></i> <span
                                class="clearfix d-sm-inline-block">Регистрация</span></a>
                </li>
<?php endif ?>
            </ul>
        </div>
    </nav>

</header>
<!--Main Navigation-->
