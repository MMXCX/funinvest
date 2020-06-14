<?php

namespace Controllers;

use Core\Controller;
use Lib\Flash;

class AuthController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->view->layout = 'auth';
    }

    /**
     * Страница авторизации
     */
    public function loginAction()
    {
        /**
         * Если юзер залогинен, то редирект на страницу панели управления
         */
        if (isset($_SESSION['account']['user'])) $this->view->redirect('panel');

        $vars = [
            'title' => 'Страница входа',
            'action' => $this->route['action'],
            'post' => $this->post
        ];

        /**
         * Запускаем метод авторизации и пробуем зайти
         */
        $this->model->login($this->post);

        /**
         * Если успех (триггер $success = true) то редирект на панель управления
         */
        if ($this->model->success) $this->view->redirect('panel');

        /**
         * Если не удалось, то показываем ошибку
         */
        $vars['flash'] = Flash::error($this->model->message);

        $this->view->render($vars);
    }

    /**
     *  Registration
     */
    public function registerAction()
    {
        /**
         * Если узер уже залогинен, то редирект на панель управления
         */
        if (isset($_SESSION['account']['user'])) $this->view->redirect('panel');

        $vars = [
            'title' => 'Страница регистрации',
            'action' => $this->route['action'],
            'post' => $this->post,

            /**
             * Вынимаем Нискнейм того, кто пригласил
             */
            'inviter' => $this->model->getNicknameById($_SESSION['inviter_id'] ?? null)
        ];

        /**
         * Запускаем метод регистрации
         */
        $this->model->register($this->post);

        /**
         * Выводим тип сообщения в зависимости от триггера $success
         */
        $vars['flash'] = $this->model->success ? Flash::success($this->model->message) : Flash::error($this->model->message);

        /**
         * Переносим значение триггера $success в вид
         */
        $vars['success'] = $this->model->success ? true : false;

        $this->view->render($vars);
    }

    /**
     * Реф ссылка с $id того, кто пригласил
     */
    public function refAction()
    {
        /**
         * Проверяем, если в сессии нет $id инвайтера, то смотрим существует ли пользователь с этим $id. Если да,
         * записываем этот $id в сессию
         */
        if (!isset($_SESSION['inviter_id'])) {
            if ($this->model->getNicknameById($this->route['id'])) {
                $_SESSION['inviter_id'] = $this->route['id'];
            }
        };

        /**
         * Редиректим на главную
         */
        $this->view->redirect('');
    }

    /**
     * Подтверждение Email по ссылке с ключем $key
     */
    public function confirmAction()
    {
        /**
         * Находти $id по ключу
         */
        $result = $this->model->getIdByConfirmKey($this->route['key']);

        /**
         * Если пользователь с таким ключем найден, то подтверждаем Email методом по $id
         */
        if ($result) {
            $this->model->confirmUserById($result);

            /**
             * Авторизируемся
             */
            $_SESSION['account']['user'] = $result;

            /**
             * И редирект на панель управления
             */
            $this->view->redirect('panel');
        } else {

            /**
             * Иначе, если вдруг уже авторизированны, то редирект на панель управления. Если нет, то на главную
             */
            isset($_SESSION['account']['user']) ? $this->view->redirect('panel') : $this->view->redirect('');
        }
    }

    /**
     * Страница востановления доступа. Требует только Email
     */
    public function recoveryAction()
    {

        /**
         * Если вдруг авторизированны, то редирект на панель управления
         */
        if (isset($_SESSION['account']['user'])) {
            $this->view->redirect('panel');
        } else {
            $vars = [
                'title' => 'Востановление пароля',
                'action' => $this->route['action'],
                'post' => $this->post,
                'flash' => ''
            ];

            /**
             * Если поле Email не пустое то...
             */
            if (isset($this->post['email'])) {

                /**
                 * Запускаем метод востановления. И в зависимости от результата выводим сообщение
                 * нужного типа
                 */
                if ($this->model->recovery($this->post['email'])) {
                    $vars['flash'] = Flash::success($this->model->message);
                } else {
                    $vars['flash'] = Flash::error($this->model->message);
                }

            }

            /**
             * Перекидываем триггер $success в вид
             */
            $vars['success'] = $this->model->success;

            $this->view->render($vars);
        }
    }

    /**
     * Форма для смены паролья с использование $key
     */
    public function set_passAction()
    {
        $vars = [
            'title' => 'Новый пароль',
            'key' => $this->route['key'],
            'action' => $this->route['action'],
            'flash' => '',
            'post' => $this->post
        ];

        /**
         * Находим никнейм по ключу постановления
         */
        $nickname = $this->model->getNickNameByRecoveryKey($this->route['key']);

        /**
         * Если пользователь не найден, то редирект на главную
         */
        if (!$nickname) $this->view->redirect('');

        /**
         * Если поля не пустые, то...
         */
        if (isset($this->post['password']) && isset($this->post['password2'])) {

            /**
             * ...пробуем сменить пароль и выводим сообщение в зависимости от результата
             */
            if ($this->model->setPassword($nickname, $this->post)) {
                $vars['flash'] = Flash::success($this->model->message);
            } else {
                $vars['flash'] = Flash::error($this->model->message);
            }
        }

        /**
         * Перекидываем триггер $success в вид
         */
        $vars['success'] = $this->model->success;

        $this->view->render($vars);
    }

    /**
     * Акшен выхода
     */
    public function logoutAction()
    {
        /**
         * Если авторизирован, то разрушаем сессию и удаляем значение $id из $_SESSION
         */
        if (isset($_SESSION['account']['user'])) {

            unset($_SESSION['account']['user']);
            session_destroy();
        }

        /**
         * Редирект на страницу входа
         */
        $this->view->redirect('login');
    }
}