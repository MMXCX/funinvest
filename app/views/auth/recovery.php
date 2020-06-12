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

                    <p class="h4 mb-4">Востановление пароля</p>

                    <?= $flash ?>
<?php if (!$success) : ?>
                    <!-- E-mail -->
                    <div class="md-form md-outline">
                        <input type="email" id="email_id" name="email" class="form-control mb-4" maxlength="50"
                               required autofocus value="<?= $post['email'] ?? '' ?>">
                        <label for="email_id">E-mail</label>
                    </div>

                    <!-- Sign in button -->
                    <button class="btn btn-info btn-block my-4" type="submit">Отправить</button>
<?php endif; ?>
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