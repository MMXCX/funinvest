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
        $test = [
            'name' => 'Mark',
            'surname' => 'Semenow',
            'age' => '23',
            'passport' => [
                'seria' => 'KH',
                'number' => '555123'
            ]
        ];
        echo json_encode($test);
        die;
    }
}