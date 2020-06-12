<?php

namespace Controllers;

use Core\Controller;
use Illuminate\Database\Capsule\Manager as Capsule;

class PageController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->view->layout = 'page';
    }

    public function aboutAction()
    {
        $vars = [
            'title' => 'О компании',
            'action' => $this->route['action']
        ];

        $this->view->render($vars);
    }

    public function contactAction()
    {
        $vars = [
            'title' => 'Напишите нам',
            'action' => $this->route['action']
        ];

        $this->view->render($vars);
    }

    public function termsAction()
    {
        $vars = [
            'title' => 'Правиля пользования',
            'action' => $this->route['action']
        ];

        $this->view->render($vars);
    }
}