<?php

namespace Controllers;

use Core\Controller;
use Illuminate\Database\Capsule\Manager as Capsule;

class ApiController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function indexAction()
    {
        if ($this->post['action'] = 'save_settings') {
            echo $this->model->saveSettings($this->post);
            exit;
        }










//        $test = [
//            'type' => 'alert-warning',
//            'message' => 'Sonthing is whong',
//            'title' => 'Error'
//        ];
//        echo json_encode($test);
//        die;
    }
}