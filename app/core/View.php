<?php

namespace Core;

class View {

    /**
     * Путь к файлу вида
     */
    public $path;
    
    /**
     * Хранит в себе Controller, Action а также входные параметры
     */
    public $route;

    /**
     * Выбор шаблона из папки app/layouts
     */
    public $layout = 'default';

    public function __construct($route) {
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($vars = []) {

        /**
         * Распаковываем массив в переменные и передаем в именной вид
         */
        extract($vars);
        if (file_exists('app/views/'.$this->path.'.php')) {
            ob_start();
            require 'app/views/'.$this->path.'.php';
            $content = ob_get_clean();
            require 'app/layouts/'.$this->layout.'.php';          
        } else {
            echo 'Файл вида <b>'.'app/views/'.$this->path.'.php'.'</b> не найден.';
        }
    }

    public static function redirect($url) {
        header('location: /' . $url);
        exit;
    }

    public static function errorCode($code) {

        http_response_code($code);

        $path = 'app/layouts/err/' . $code . '.php';

        if (file_exists($path)) {
            require_once $path;
            exit;
        } else {
            View::redirect('');
        }
    }

    public function message($status, $message) {
        exit(json_encode([
            'status' => $status,
            'message' => $message
        ]));
    }
    
    public function location($url) {
        exit(json_encode([
            'url' => $url
        ]));
    }
}