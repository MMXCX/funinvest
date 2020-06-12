<?php

namespace Core;
/**
 * 
 * 
 */
class Router
{
    /**
     * Хранит массив роутов в обработанном виде:
     * Array
     * (
     *     [#^main/(?P<page>\d+)$#] => Array
     *         (
     *             [controller] => main
     *             [action] => index
     *         )
     * 
     * )
     * 
     * @var array
     */
    protected $routes = [];

    /**
     * Хранит массив роутов в обработанном виде:
     * Array
     * (
     *     [controller] => main
     *     [action] => index
     *     [page] => 5
     * )
     * 
     * @var array
     */
    protected $params = [];

    /**
     * Загружаем роуты из файла и заполняем переменные $routes и $params
     */
    public function __construct()
    {
        $arr = require 'app/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    /**
     * Делаем паттерны для роутов
     */
    public function add($route, $params)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route); 
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    /**
     * Проверяет URL на наличие в списке роутов
     * 
     * @return bool
     */
    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Запуск приложения
     */
    public function run()
    {
        if ($this->match()) {
            $path = 'Controllers\\'.ucfirst($this->params['controller'].'Controller');
            if (class_exists($path)) {
                $action = $this->params['action'].'Action';
                if (method_exists($path, $action)) {

                    //Создаем Controller и передаем ему все параметры
                    $controller = new $path($this->params);
                    
                    //Запускаем Инициализацию и Action
                    $controller->initialize();
                    $controller->$action();
                } else {
                    return DEBUG ? exit('Акшен <b>'.$action.'</b> не найден') : View::errorCode(404);
                }
            } else {
                return DEBUG ? exit('Контроллер <b>'.$path.'</b> не найден') : View::errorCode(404);
            }
        } else {
            DEBUG ? exit('URI <b>'.trim($_SERVER['REQUEST_URI'], '/').'</b> не найден в роутах') : View::errorCode(404);
        }
    }
}