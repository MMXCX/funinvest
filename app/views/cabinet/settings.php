<?php require_once '_header.php' ?>
<!--Main Layout-->
<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-dismissible fade show" id="alert_id" role="alert" style="display: none">
                    <h4 class="alert-heading"></h4>
                    <p></p>
                </div>
            </div>
            <div class="col-12">
                <ul class="nav nav-tabs md-tabs" id="myTabEx" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="home-tab-ex" data-toggle="tab" href="#home-ex" role="tab"
                           aria-controls="home-ex"
                           aria-selected="true">Основные</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab-ex" data-toggle="tab" href="#profile-ex" role="tab"
                           aria-controls="profile-ex"
                           aria-selected="false">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab-ex" data-toggle="tab" href="#contact-ex" role="tab"
                           aria-controls="contact-ex"
                           aria-selected="false">Платежи</a>
                    </li>
                </ul>
                <div class="tab-content pt-5" id="myTabContentEx">
                    <div class="tab-pane fade active show" id="home-ex" role="tabpanel"
                         aria-labelledby="home-tab-ex">
                    </div>
                    <div class="tab-pane fade" id="profile-ex" role="tabpanel" aria-labelledby="profile-tab-ex">
                        <div class="tab-pane fade active show" id="home-ex" role="tabpanel"
                             aria-labelledby="home-tab-ex">

                            <!--Email-->
                            <div class="md-form md-outline">
                                <input type="email" id="email_id" name="email" class="form-control mb-4" maxlength="50"
                                       required value="<?= $email ?? '' ?>">
                                <label for="email_id">E-mail</label>
                            </div>

                            <!-- Current Password -->
                            <div class="md-form md-outline">
                                <input type="password" id="new_password_id" name="new_password" class="form-control"
                                       maxlength="32" required value="<?= $post['new_password'] ?? '' ?>">
                                <label for="new_password_id">Новый пароль</label>
                            </div>

                            <!-- Current Password -->
                            <div class="md-form md-outline">
                                <input type="password" id="new_password2_id" name="new_password2" class="form-control"
                                       maxlength="32" required value="<?= $post['new_password2'] ?? '' ?>">
                                <label for="new_password2_id">Новый пароль ещё раз</label>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact-ex" role="tabpanel" aria-labelledby="contact-tab-ex">

                        <!--WebMoney-->
                        <div class="md-form md-outline">
                            <input type="text" id="webmoney_id" name="webmoney" class="form-control mb-4" maxlength="13"
                                   value="<?= $webmoney ?? '' ?>">
                            <label for="webmoney_id">WebMoney</label>
                        </div>

                        <!--Qiwi-->
                        <div class="md-form md-outline">
                            <input type="text" id="qiwi_id" name="qiwi" class="form-control mb-4" maxlength="16"
                                   value="<?= $qiwi ?? '' ?>">
                            <label for="qiwi_id">Qiwi</label>
                        </div>

                        <!--Yandex-->
                        <div class="md-form md-outline">
                            <input type="text" id="yandex_id" name="yandex" class="form-control mb-4" maxlength="20"
                                   value="<?= $yandex ?? '' ?>">
                            <label for="yandex_id">Yandex</label>
                        </div>

                        <!--Card-->
                        <div class="md-form md-outline">
                            <input type="text" id="card_id" name="card" class="form-control mb-4" maxlength="19"
                                   value="<?= $card ?? '' ?>">
                            <label for="card_id">Банковская карта</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col">

                            <hr>

                            <!-- Current Password -->
                            <div class="md-form md-outline">
                                <input type="password" id="password_id" name="password" class="form-control"
                                       maxlength="32" required value="<?= $post['password'] ?? '' ?>">
                                <label for="password_id">Ваш текущий пароль</label>
                            </div>

                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col col-sm-12 col-md-4 col-lg-3">
                            <div class="btn btn-primary btn-block" onclick="sendData()" type="submit">Сохранить</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--Main Layout-->
<?php require_once '_footer.php' ?>
