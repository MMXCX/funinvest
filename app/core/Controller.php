<?php

namespace Core;

use Core\View;


abstract class Controller
{
    /**
     * Хранит в себе Controller, Action а также входные параметры
     */
    public $route;

    /**
     * Хранит объект вида
     */
    public $view;

    /**
     * Хранит объект модели
     */
    public $model;

    /**
     * Хранит ACL
     */
    public $acl;

    /**
     * Хранит get переменные
     */
    public $get;

    /**
     * Хранит post переменные
     */
    public $post;

    /**
     * Хранит информацию по тарифам (инвест единицам)
     */
    public $tariffs;

    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->get = $_GET;
        $this->post = $_POST;

        $this->route = $route;

        if (!$this->checkAcl()) {
            $route['controller'] == 'api' ? die('{"error":"403"}') : true;

            DEBUG ? exit('Доступ заприщен ACL') : View::errorCode(403);
        }

        /**
         * Создаем основной объект вида и передаем ему пораметры
         */
        $this->view  = new View($route);

        /**
         * Создаем именной объект модели NameModel
         */
        $this->model = $this->loadModel($route['controller']);
    }

    public function initialize(): void
    {

    }
    
    /**
     * Возвращает объект класса модели
     */
    public function loadModel($name)
    {
        $path = 'Models\\' . ucfirst($name).'Model';
        if (class_exists($path)) {
            return new $path;
        } else {
            exit('Класс <b>'.$path.'</b> не найден');
        }
    }
    
    /**
     * Пробегается по списку ACL и ищет разрешение
     */
    public function checkAcl()
    {
        $path = 'app/acl/' . $this->route['controller'] . '.php';
        if (file_exists($path)) {
            $this->acl = require $path;
        } else {
            exit('Файл ACL <b>' . $path . '</b> не найден.');
        }
        
        if ($this->isAcl('all')) {
            return true;
        } elseif (isset($_SESSION['account']['user']) and $this->isAcl('authorize')) {
            return true;
        } elseif (!isset($_SESSION['account']['user']) and $this->isAcl('guest')) {
            return true;
        } elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
            return true;
        }
        return false;
    }

    public function isAcl($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}
