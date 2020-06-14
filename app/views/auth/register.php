<?php require_once '_header.php' ?>
<div class="container my-5 py-5 z-depth-1">


    <!--Section: Content-->
    <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text">


        <!--Grid row-->
        <div class="row d-flex justify-content-center">

            <!--Grid column-->
            <div class="col-md-6">

                <!-- Default form register -->
                <form class="text-center" action="/register" method="post">

                    <p class="h4 mb-4">Регистрация</p>


                    <?= $flash ?>




<?php if (!$success): ?>
                    <!-- Nick name -->
                    <div class="md-form md-outline">
                        <input type="text" id="nickname_id" name="nickname" class="form-control" maxlength="32"
                               required autofocus value="<?= $post['nickname'] ?? '' ?>">
                        <label for="nickname_id">Имя в системе</label>
                        <small id="nickname_help_block_id" class="form-text text-muted mb-4">
                            Должно быть уникальным. Например "Сергей Петрович" или "Vitaly88"
                        </small>
                    </div>

                    <!-- E-mail -->
                    <div class="md-form md-outline">
                        <input type="email" id="email_id" name="email" class="form-control mb-4" maxlength="50"
                               required value="<?= $post['email'] ?? '' ?>">
                        <label for="email_id">E-mail</label>
                    </div>

                    <!-- Password -->
                    <div class="md-form md-outline">
                        <input type="password" id="password_id" name="password" class="form-control"
                               maxlength="32" required value="<?= $post['password'] ?? '' ?>">
                        <label for="password_id">Пароль</label>
                    </div>

                    <!-- Password 2-->
                    <div class="md-form md-outline">
                        <input type="password" id="password_2_id" name="password_2" class="form-control"
                               maxlength="32" required value="<?= $post['password_2'] ?? '' ?>">
                        <label for="password_2_id">Повторите пароль</label>
                        <small id="password_help_block_id" class="form-text text-muted mb-4">
                            Не менее 8 символов и одной цифры
                        </small>
                    </div>
<?php if (isset($_SESSION['inviter_id'])) : ?>
                    <!-- Inviter -->
                    <div class="md-form md-outline">
                        <input type="text" id="inviter" class="form-control" disabled>
                        <label for="inviter" class="disabled"><?= $inviter ?></label>
                        <small id="inviter_help_block_id" class="form-text text-muted mb-4">
                            Вас пригласил
                        </small>
                    </div>
<?php endif; ?>
                    <!-- Sign up button -->
                    <button class="btn btn-info my-4 btn-block" type="submit">Зарегистрировать</button>

                    <!-- Social register -->
                    <p>или войдите в систему:
                        <a href="/login">Вход</a>
                    </p>

                    <hr>
<?php endif; ?>
                    <!-- Terms of service -->
                    <p>Нажимая кнопку
                        <em>Регистрации</em> вы соглошаетесь с
                        <a href="/terms" target="_blank">правилами использования</a>

                </form>
                <!-- Default form register -->

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->


    </section>
    <!--Section: Content-->


</div>