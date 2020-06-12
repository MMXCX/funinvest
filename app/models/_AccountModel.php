<?php


namespace Models;

use Core\Model;
use Illuminate\Database\Capsule\Manager;


class AccountModel extends Model
{
    public $error;

    public function login(array $post)
    {
        if (isset($post['login']) and isset($post['pass'])) {
            if ($post['login'] == '') {
                $this->error = 'Заполните поле Логин!';
            } elseif (!$this->getUserByLogin($post['login'])) {
                $this->error = 'Пользователь с таким логином не существует!';
            } elseif ($post['pass'] == '') {
                $this->error = 'Заполните поле Пароль!';
            } elseif (!$this->verifyPass($post['login'], $post['pass'])) {
                $this->error = 'Не правильный пароль';
            } elseif (!$this->isUserConfirmed($post['login'])) {
                $this->error = 'Аккаун еще не подтвержден. Проверьте вашу почту и перейдите по ссылке для подтверждения.';
            } else {
                $_SESSION['account']['user'] = $this->getUserByLogin($post['login']);
                header('Location: /cabinet');
            }
        }
    }

    public function recover($post)
    {
        if (isset($post['email'])) {
            if ($post['email'] == '') {
                $this->error = 'Заполните поле Email!';
            } elseif (!$this->validateEmail($post['email'])) {
                $this->error = 'Не верный формат E-mail!';
            } elseif (!$this->isEmailInUse($post['email'])) {
                $this->error = 'Email не найден в базе данных';
            } elseif (!$this->isEmailConfirmed($post['email'])) {
                $this->error = 'Email еще не подтвержден. Проверьте почту';
            } else {
                $this->error = 'no error';
                $recover_key = md5($post['email'] . microtime());
                $this->setRecoverKey($post['email'], $recover_key);
                $this->sendRecoverEmail($post['email'], $recover_key);
            }
        }
    }

    public function recover_form($post, $key)
    {
        if (!$this->recoverKeyExist($key)) {
            header('Location: /');
            exit();
        }
        if (isset($post['pass1']) and isset($post['pass2'])) {
            if ($post['pass1'] == '' or $post['pass2'] == '') {
                $this->error = 'Заполните все поля!';
            } elseif (!$this->validatePass($post['pass1'])) {
                $this->error = 'Пароль должен содержать a-zA-Z0-9_ и быть от 6 до 32 символов!';
            } elseif ($post['pass1'] != $post['pass2']) {
                $this->error = 'Пароли должны совпадать!';
            } else {
                $this->setNewPassword($key, $post['pass1']);
                $this->error = 'no error';
            }
        }
    }

    public function recoverKeyExist($key)
    {
        return $this->db->getAll('SELECT * FROM `users` WHERE `recover_key`=?s', $key);
    }

    public function setNewPassword($key, $pass)
    {
        $pass = hash('sha512', $pass);
        $this->db->query('UPDATE `users` SET `password`=?s,`recover_key`=?s WHERE `recover_key`=?s', $pass, '', $key);
    }

    public function setRecoverKey($email, $recover_key)
    {
        $this->db->query('UPDATE `users` SET `recover_key`=?s WHERE `email`=?s', $recover_key, $email);
    }

    public function register(array $post)
    {
        if (isset($post['login']) && isset($post['pass']) && isset($post['pass2']) && isset($post['email'])) {
            if ($post['login'] == '') {
                $this->error = 'Заполните поле Логин!';
            } elseif (!$this->validateLogin($post['login'])) {
                $this->error = 'Логин должен содержать a-zA-Z0-9_ и быть от 3 до 32 символов!';
            } elseif ($this->getUserByLogin($post['login'])) {
                $this->error = 'Пользователь с таким логином уже существует!';

            } elseif ($post['pass'] == '') {
                $this->error = 'Заполните поле Пароль!';
            } elseif (!$this->validatePass($post['pass'])) {
                $this->error = 'Пароль должен содержать a-zA-Z0-9_ и быть от 6 до 32 символов!';

            } elseif ($post['pass2'] == '') {
                $this->error = 'Повторите пароль еще раз';
            } elseif ($post['pass'] != $post['pass2']) {
                $this->error = 'Пароли не совподают';

            } elseif ($post['email'] == '') {
                $this->error = 'Введите ваш E-mail';
            } elseif (!$this->validateEmail($post['email'])) {
                $this->error = 'Не верный формат E-mail!';
            } elseif ($this->isEmailInUse($post['email']) && $this->isEmailConfirmed($post['email'])) {
                $this->error = 'Этот E-mail уже используется. Придумайте другой.';
            } else {
                if ($this->isEmailInUse($post['email']) && !$this->isEmailConfirmed($post['email'])) {
                    $this->db->query('DELETE FROM `users` WHERE `email`=?s', $post['email']);
                }
                $this->createUser($post);
                $this->error = 'no error';
            }
        }
    }

    public function validateLogin($login)
    {
        return preg_match('#^[a-zA-Z0-9_]{3,32}$#', $login);
    }

    public function validatePass($pass)
    {
        return preg_match('#^[a-zA-Z0-9_]{6,32}$#', $pass);
    }

    public function validateEmail($email)
    {
        return preg_match('#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$#', $email);
    }

    public function getUserByLogin($login)
    {
        return $this->db->getRow('SELECT * FROM `users` WHERE `login`=?s', $login);
    }

    public function verifyPass($login, $pass)
    {
        $result = $this->db->getOne('SELECT `password` FROM `users` WHERE `login`=?s', $login);
        return hash('sha512', $pass) == $result;
    }

    public function getIdByLogin($login)
    {
        return $this->db->getOne('SELECT `id` FROM `users` WHERE `login`=?s', $login);
    }

    public function getLoginByEmail($email)
    {
        return $this->db->getOne('SELECT `login` FROM `users` WHERE `email`=?s', $email);
    }

    public function isEmailInUse($email)
    {
        return $this->db->getOne('SELECT `id` FROM `users` WHERE `email`=?s', $email);
    }

    public function isEmailConfirmed($email)
    {
        return $this->db->getOne('SELECT `confirmed` FROM `users` WHERE `email`=?s', $email);
    }

    public function isUserConfirmed($login)
    {
        return $this->db->getOne('SELECT `confirmed` FROM `users` WHERE `login`=?s', $login);
    }

    public function createUser($post)
    {
        $login = strtolower($post['login']);
        $password = hash('sha512', $post['pass']);
        $email = strtolower($post['email']);
        $reg_time = time();
        $confirm_key = md5($login . $password . $email . microtime());
        $inviter_id = 0;
        if (isset($post['inviter'])) {
            if ($this->userExist($post['inviter'])) {
                $inviter_id = $this->getIdByLogin($post['inviter']);
            }
        }
        $this->confirmEmail($login, $email, $confirm_key);
        $this->db->query('INSERT INTO `users`(`login`,`password`,`email`,`reg_time`,`confirm_key`,`inviter`) VALUES (?s,?s,?s,?i,?s,?i)', $login, $password, $email, $reg_time, $confirm_key, $inviter_id);

        //Создаем стартовый пакет
        $userId = $this->db->getOne('SELECT `id` FROM `users` WHERE `login`=?s', $login);
        $this->createStartSet($userId);

    }

    public function createStartSet($userId)
    {
        $this->db->query('INSERT INTO `actives`(`quantity`,`type_id`,`owner_id`,`update_time`) VALUES (?s,?s,?s,?s)', 1, 1, $userId, time());
    }

    public function confirmEmail($login, $email, $confirm_key)
    {
        $to = ucfirst($login) . ' <' . $email . '>';
        $subject = 'Подтверждение Email';
        $message = '<tbody>
<tr>
    <td bgcolor="#ffffff" style="border-radius:6px">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td style="padding:42px 10px 0px">
                    <table width="554" align="center" style="width:100%!important;max-width:554px;margin:0 auto"
                           cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td align="center"
                                style="padding:0 0px 21px;font:17px/24px Arial,Helvetica,sans-serif;color:#333">
                                Здравствуйте, ' . ucfirst($login) . '.
                            </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="padding:0 0 8px;font:30px/36px San Francisco,Segoe,Roboto,Arial,Helvetica,sans-serif;color:#333">
                                Подтвердите вашу регистрацию
                            </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="padding:0 0 21px;font:21px/30px San Francisco,Segoe,Roboto,Arial,Helvetica,sans-serif;color:#333">
                                Для этого перейдите по этой <a href="' . WEB_DOMAIN . '/confirm/' . $confirm_key . '">ссылке</a> иначе просто проигнарируйте это сообщение.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>';
        $headers = array(
            'From' => FROM_FIELD . ' <' . CONFIRM_EMAIL . '>',
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=utf-8'
        );

        mail($to, $subject, $message, $headers);
    }

    public function sendRecoverEmail($email, $recover_key)
    {
        $login = $this->getLoginByEmail($email);
        $to = ucfirst($login) . ' <' . $email . '>';
        $subject = 'Изменение пароля';
        $message = '<tbody>
<tr>
    <td bgcolor="#ffffff" style="border-radius:6px">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td style="padding:42px 10px 0px">
                    <table width="554" align="center" style="width:100%!important;max-width:554px;margin:0 auto"
                           cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td align="center"
                                style="padding:0 0px 21px;font:17px/24px Arial,Helvetica,sans-serif;color:#333">
                                Здравствуйте, ' . ucfirst($login) . '.
                            </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="padding:0 0 8px;font:30px/36px San Francisco,Segoe,Roboto,Arial,Helvetica,sans-serif;color:#333">
                                Введите ваш новый пароль
                            </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="padding:0 0 21px;font:21px/30px San Francisco,Segoe,Roboto,Arial,Helvetica,sans-serif;color:#333">
                                Для этого перейдите по этой <a href="' . WEB_DOMAIN . '/recover/' . $recover_key . '">ссылке</a> иначе просто проигнарируйте это сообщение.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
</tbody>';
        $headers = array(
            'From' => FROM_FIELD . ' <' . SUPPORT_EMAIL . '>',
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=utf-8'
        );

        mail($to, $subject, $message, $headers);
    }

    public function confirm($key)
    {
        if ($this->isKeyExist($key)) {
            $this->db->query('UPDATE `users` SET `confirmed`=1,`confirm_key`=?s WHERE `confirm_key`=?s', '', $key);
            return true;
        };
        return false;
    }

    public function isKeyExist($key)
    {
        return $this->db->getAll('SELECT * FROM `users` WHERE `confirm_key`=?s', $key) ? true : false;
    }

    public function userExist($login)
    {
        return $this->db->getAll('SELECT * FROM `users` WHERE `login`=?s AND `confirmed`=1', $login);
    }
}