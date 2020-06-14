<?php require_once '_header.php' ?>
<div class="container my-5 py-5 z-depth-1">


    <!--Section: Content-->
    <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text">


        <!--Grid row-->
        <div class="row d-flex justify-content-center">

            <!--Grid column-->
            <div class="col-md-6">

                <!-- Default form login -->
                <form class="text-center" action="" method="post">

                    <p class="h4 mb-4">Введите новый пароль:</p>

                    <?= $flash ?>
<?php if (!$success) : ?>
                    <!-- Password -->
                    <div class="md-form md-outline">
                        <input type="password" id="password_id" name="password" class="form-control"
                               maxlength="32" required autofocus value="<?= $post['password'] ?? '' ?>">
                        <label for="password_id">Пароль</label>
                    </div>

                    <!-- Password2 -->
                    <div class="md-form md-outline">
                        <input type="password" id="password2_id" name="password2" class="form-control"
                               maxlength="32" required autofocus value="<?= $post['password2'] ?? '' ?>">
                        <label for="password2_id">Пароль еще раз</label>
                    </div>

                    <!-- Sign in button -->
                    <button class="btn btn-info btn-block my-4" type="submit">Сохранить</button>

                    <!-- Login -->
                    <p>Вспомнили пароль?
                        <a href="/login">Вход</a>
                    </p>
<?php else : ?>
                    <!-- Login -->
                    <p>Войти в систему
                        <a href="/login">Вход</a>
                    </p>
<?php endif; ?>
                </form>
                <!-- Default form login -->

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->


    </section>
    <!--Section: Content-->


</div>