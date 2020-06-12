<?php


namespace Models;

use Core\Model;


class CabinetModel extends Model
{
    public $error;


    public function getUserById($id)
    {
        return $this->db->getRow('SELECT * FROM `users` WHERE `id`=?s', $id);
    }

    public function getActivesListByUserId($id)
    {
        return $this->db->getAll('SELECT * FROM `actives` WHERE `owner_id`=?s ORDER BY `type_id`', $_SESSION['account']['user']['id']);
    }
}