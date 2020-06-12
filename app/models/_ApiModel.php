<?php


namespace Models;

use Core\Model;


class ApiModel extends Model
{
    public $error;

    public function printJSON($post)
    {
        if (isset($post['action'])) {
            if ($post['action'] == 'collect') {
                if ($this->getOwnerIdById($post['id']) == $_SESSION['account']['user']['id']) {
                    $ajax['id'] = $post['id'];

                    $this->collectActive($post['id']);

                    $ajax['balance'] = $this->getCurrentUserBalance();
                    echo json_encode($ajax);
                }
            }




        }
    }

    public function getCurrentUserBalance()
    {
        return $this->db->getOne('SELECT `balance` FROM `users` WHERE `id`=?s', $_SESSION['account']['user']['id']);
    }

    public function getOwnerIdById($id)
    {
        return $this->db->getOne('SELECT `owner_id` FROM `actives` WHERE `id`=?s', $id);
    }

    public function collectActive($id)
    {
        $user = $this->db->getRow('SELECT * FROM `users` WHERE `id`=?s', $_SESSION['account']['user']['id']);
        $active = $this->db->getRow('SELECT * FROM `actives` WHERE `id`=?s', $id);
        $percent = $this->tariffs[$active['type_id']]['percent'];
        $price = $this->tariffs[$active['type_id']]['cost'];
        $quantity = $active['quantity'];
        $timestamp = time();
        $time = $timestamp - $active['update_time'];
        $collected = intval($percent * $price * $quantity / 162 * 625 * $time);
        $new_user_balance = $user['balance'] + $collected;
        $this->db->query('UPDATE `users` SET `balance`=?s WHERE `id`=?s', $new_user_balance, $user['id']);
        $this->db->query('UPDATE `actives` SET `update_time`=?s WHERE `id`=?s', $timestamp, $active['id']);
    }
}