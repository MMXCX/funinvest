<?php


namespace Models;

use Core\Model;
use Illuminate\Database\Capsule\Manager as Capsule;


class CabinetModel extends Model
{
    public function getUserById($id)
    {
        return Capsule::table('users')
            ->where('id', '=', $_SESSION['account']['user'])
            ->first();
    }
}