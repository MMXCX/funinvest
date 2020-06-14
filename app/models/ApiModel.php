<?php


namespace Models;

use Core\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Lib\Hasher;


class ApiModel extends Model
{
    public function saveSettings($post): string
    {
        $alert = [
            'type' => 'alert-success',
            'title' => 'Успешно!',
            'message' => 'Ваши настройки были успешно сохранены.'
        ];

        if (isset($_SESSION['account']['user'])) {
            if (!$this->_comparePassword($post['password'])) {
                $alert = [
                    'type' => 'alert-danger',
                    'title' => 'Ошибка!',
                    'message' => 'Для сохранения любых изменения в настройках нужно указать Ваш текущий пароль.'
                ];
            } elseif (!$this->_validateEmail($post['email'])) {
                $alert = [
                    'type' => 'alert-danger',
                    'title' => 'Ошибка!',
                    'message' => 'Email должен быть больше 6 и меньше 32 символов, а так же иметь правильный формат.
                    Например "sergey86@gmail.com" или "aleksander@yandex.ru"'
                ];
            } elseif (!empty($post['new_password']) or !empty($post['new_password2'])) {
                if (!$this->_validatePassword($post['new_password'])) {
                    $alert = [
                        'type' => 'alert-danger',
                        'title' => 'Ошибка!',
                        'message' => 'Длинна нового пароля должна составлять от 8 до 32 символов. Во избежании проблем с доступом
                        избегайте использования руских буков.'
                    ];
                } elseif ($post['new_password'] != $post['new_password2']) {
                    $alert = [
                        'type' => 'alert-danger',
                        'title' => 'Ошибка!',
                        'message' => 'Новые пароли не совпадают'
                    ];
                }
            }








            if ($alert['type'] == 'alert-success') {

                $this->_updateUserSettings($post);
            }

            return json_encode($alert);
        }
        return json_encode([]);
    }






    private function _comparePassword($password)
    {
        $hash = Capsule::table('users')
            ->where('id', '=', $_SESSION['account']['user'])
            ->first()->password;

        return Hasher::hashe($password) == $hash;
    }

    private function _updateUserSettings($post)
    {
        $values = [
            'email' => $post['email']
        ];

        if (!empty($post['new_password'])) $values['password'] = Hasher::hashe($post['new_password']);



        Capsule::table('users')
            ->where('id', '=', $_SESSION['account']['user'])
            ->update($values);
    }

    private function _validateWebmoney($webmoney)
    {
        return preg_match('#^[ZER][0-9]{12}$#', $webmoney);
    }
}