<?php


namespace Models;

use Core\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Lib\Hasher;
use Lib\Validator;


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
            } elseif (!Validator::email($post['email'])) {
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
            } elseif (!empty($post['webmoney']) && !$this->_validateWebmoney($post['webmoney'])) {
                $alert = [
                    'type' => 'alert-danger',
                    'title' => 'Ошибка!',
                    'message' => 'Не верный формат WebMoney кошелька. Используйте первую заглавную латинскую букву и
                    12 цифр после. Например "R123456789012" или "Z987654321098"'
                ];
            } elseif (!empty($post['qiwi']) && !$this->_validatePhone($post['qiwi'])) {
                $alert = [
                    'type' => 'alert-danger',
                    'title' => 'Ошибка!',
                    'message' => 'Не верный формат Qiwi кошелька. Используйте номер телефона в международном
                    формате. Первый символ "+" и далее цифры без скобок и тире. Например "+79991234567" или "+375291234567"'
                ];
            } elseif (!empty($post['yandex']) && !$this->_validateYandex($post['yandex'])) {
                $alert = [
                    'type' => 'alert-danger',
                    'title' => 'Ошибка!',
                    'message' => 'Не верный формат Yandex кошелька. Используйте номер телефона в международном
                    формате. Первый символ "+" и далее цифры без скобок и тире. Или номер счёта из цифр.
                    Например "+79991234567" или "123456789012345678"'
                ];
            } elseif (!empty($post['card']) && !$this->_validateCard($post['card'])) {
                $alert = [
                    'type' => 'alert-danger',
                    'title' => 'Ошибка!',
                    'message' => 'Не верный формат номера карты. Используйте цифры без пробелов и разделителей.                  формате. Первый символ "+" и далее цифры без скобок и тире. Или номер счёта из цифр.
                    Например "1234567890123456"'
                ];
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
            'email' => $post['email'],
            'webmoney' => $post['webmoney'],
            'qiwi' => $post['qiwi'],
            'yandex' => $post['yandex'],
            'card' => $post['card']
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

    private function _validatePhone($phone)
    {
        return preg_match('#^[+]{1}[0-9]{11,15}$#', $phone);
    }

    private function _validateYandex($yandex)
    {
        return preg_match('#^[0-9]{11,20}$#', $yandex) or $this->_validatePhone($yandex);
    }

    private function _validateCard($card)
    {
        return preg_match('#^[0-9]{13,19}$#', $card);
    }
}