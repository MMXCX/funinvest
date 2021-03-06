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

                    <p class="h4 mb-4">Вход</p>

                    <?= $flash ?>

                    <!-- E-mail -->
                    <div class="md-form md-outline">
                        <input type="email" id="email_id" name="email" class="form-control mb-4" maxlength="50"
                               required autofocus value="<?= $post['email'] ?? '' ?>">
                        <label for="email_id">E-mail</label>
                    </div>

                    <!-- Password -->
                    <div class="md-form md-outline">
                        <input type="password" id="password_id" name="password" class="form-control"
                               maxlength="32" required value="<?= $post['password'] ?? '' ?>">
                        <label for="password_id">Пароль</label>
                    </div>

                    <div class="d-flex justify-content-around">

                        <!-- Material unchecked -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember_id">
                            <label class="form-check-label" for="remember_id">Запомнить меня</label>
                        </div>




                        <div>
                            <!-- Forgot password -->
                            <a href="/recovery">Не помните пароль?</a>
                        </div>
                    </div>

                    <!-- Sign in button -->
                    <button class="btn btn-info btn-block my-4" type="submit">Войти</button>

                    <!-- Register -->
                    <p>Нет аккаунта?
                        <a href="/register">Зарегистрируйтесь</a>
                    </p>

                </form>
                <!-- Default form login -->

            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->


    </section>
    <!--Section: Content-->


</div>