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
    }

    public function panelAction()
    {
        $_SESSION['account']['user'] ?? $this->view->redirect('login');



        $vars = [
            'title' => 'Панель управления'
        ];

        $this->view->render($vars);
    }
}