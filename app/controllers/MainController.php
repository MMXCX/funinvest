<?php

namespace Controllers;

use Core\Controller;
use Illuminate\Database\Capsule\Manager as Capsule;

class MainController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->view->layout = 'main';
    }

    public function indexAction()
    {
//        $this->migration();
        $users = Capsule::table('users')->where('id', '>', 0)->get();


        $vars = [
            'title' => 'Главная страница',
            'users' => $users
        ];

        $this->view->render($vars);
    }

    public function migration()
    {
//        Capsule::table('users')->where('id', '=', 3)->update(['login' => 'Olia']);

//        Capsule::table('users')->insert([
//            'login' => 'fuck',
//            'email' => 'fuck@admin.com',
//            'password' => '123',
//            'reg_time' => time(),
//            'confirm_key' => 'not'
//            ]);

//        Capsule::table('users')->delete(8);

        Capsule::schema()->drop('users');

        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('nickname', 32)->unique();
            $table->string('email', 50)->unique();
            $table->string('password', 256);
            $table->integer('reg_time');
            $table->string('confirm_key', 32);
            $table->string('recovery_key', 32)->default('');
            $table->integer('inviter_id')->default(0);
            $table->boolean('confirmed')->default(false);
            $table->bigInteger('balance')->default(0);
        });
    }
}