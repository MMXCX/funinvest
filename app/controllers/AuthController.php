<?php

namespace Controllers;

use Core\Controller;
use Lib\Flash;
use Lib\Hasher;

class AuthController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->view->layout = 'auth';
    }

    public function loginAction()
    {
        isset($_SESSION['account']['user']) ? $this->view->redirect('panel') : true;

        $vars = [
            'title' => 'Страница входа',
            'action' => $this->route['action'],
            'post' => $this->post
        ];

        $this->model->login($this->post);
        $this->model->success ? $this->view->redirect('panel') : true;

        $vars['flash'] = Flash::error($this->model->message);

        $this->view->render($vars);
    }

    /**
     *  Registration
     */
    public function registerAction()
    {
        isset($_SESSION['account']['user']) ? $this->view->redirect('panel') : true;

        $vars = [
            'title' => 'Страница регистрации',
            'action' => $this->route['action'],
            'post' => $this->post,
            'inviter' => $this->model->getNicknameById($_SESSION['inviter_id'] ?? null)
        ];

        $this->model->register($this->post);

        $vars['flash'] = $this->model->success ? Flash::success($this->model->message) : Flash::error($this->model->message);
        $vars['success'] = $this->model->success ? true : false;

        $this->view->render($vars);
    }

    public function refAction()
    {
        if (!isset($_SESSION['inviter_id'])) {
            if ($this->model->getNicknameById($this->route['id'])) {
                $_SESSION['inviter_id'] = $this->route['id'];
            }
        };

        $this->view->redirect('');
    }

    public function confirmAction()
    {
        $result = $this->model->getIdByConfirmKey($this->route['key']);

        if ($result) {
            $this->model->confirmUserById($result);
            $_SESSION['account']['user'] = $result;
            $this->view->redirect('panel');
        } else {
            isset($_SESSION['account']['user']) ? $this->view->redirect('panel') : $this->view->redirect('');
        }
    }

    public function recoveryAction()
    {

        if (isset($_SESSION['account']['user'])) {
            $this->view->redirect('panel');
        } else {
            $vars = [
                'title' => 'Востановление пароля',
                'action' => $this->route['action'],
                'post' => $this->post,
                'flash' => ''
            ];

            if (isset($this->post['email'])) {
                if ($this->model->recovery($this->post['email'])) {
                    $vars['flash'] = Flash::success($this->model->message);
                } else {
                    $vars['flash'] = Flash::error($this->model->message);
                }

            }

            $vars['success'] = $this->model->success;

            $this->view->render($vars);
        }
    }

    public function set_passAction()
    {
        $vars = [
            'title' => 'Новый пароль',
            'key' => $this->route['key']
        ];

        $this->view->render($vars);
    }

    public function logoutAction()
    {
        if (!isset($_SESSION['account']['user'])) {
            $this->view->redirect('login');
        } else {
            session_destroy();

            unset($_SESSION['account']['user']);

            $this->view->redirect('login');
        }
    }
}