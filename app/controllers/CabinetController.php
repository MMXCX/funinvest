<?php

namespace Controllers;

use Core\Controller;
use Illuminate\Database\Capsule\Manager as Capsule;

class CabinetController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->view->layout = 'cabinet';

        /**
         * Если не авторизированы, то редирект на главную
         */
        if (!isset($_SESSION['account']['user'])) $this->view->redirect('login');
    }

    /**
     * Главная панель управления
     */
    public function panelAction()
    {
        $vars = [
            'title' => 'Панель управления'
        ];

        $this->view->render($vars);
    }

    /**
     * Настройки аккаунта
     */
    public function settingsAction()
    {
        $user = $this->model->getUserById($_SESSION['account']['user']);

        $vars = [
            'title' => 'Настройки',
            'email' => $user->email,
            'webmoney' => $user->webmoney,
            'qiwi' => $user->qiwi,
            'yandex' => $user->yandex,
            'card' => $user->card
        ];

        $this->view->render($vars);
    }

    /**
     * Пополнение счета
     */
    public function depositAction()
    {
        $vars = [
            'title' => 'Пополнение счёта'
        ];

        $this->view->render($vars);
    }

    /**
     * Выплаты
     */
    public function payoutAction()
    {
        $vars = [
            'title' => 'Выплаты'
        ];

        $this->view->render($vars);
    }
}