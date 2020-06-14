<?php


namespace Models;

use Core\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Lib\Hasher;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class AuthModel extends Model
{
    public $message;

    public $success = false;

    public function register($post)
    {
        if (isset($post['nickname']) && isset($post['email']) && isset($post['password']) && isset($post['password_2'])) {

            if (!$this->_validateNickname($post['nickname'])) {
                $this->message = 'Не правильный формат Имени в системе. Можно использовать кириллицу, латинские буквы,
                цифры, пробелы и символы нижнего и среднего подчеркивания. А также длина должна быть от 3 до 32 символов.
                Например "Сергей Петрович" или "Vitaly88"';
            } elseif ($this->_isNicknameInUse($post['nickname'])) {
                $this->message = 'Данное имя уже используется в системе. Придумайте другое.';
            } elseif (!$this->_validateEmail($post['email'])) {
                $this->message = 'Не верно указан формат E-mail. Например: markmain@mail.ru, ValentinIzmailov@Gmail.com
                (допускается не более 50 символов)';
            } elseif ($this->_isEmailInUse($post['email'])) {
                $this->message = 'Такой E-mail уже используется в системе. Попробуйте другой.';
            } elseif (!$this->_validatePassword($post['password'])) {
                $this->message = 'Длинна пароля должна составлять от 8 до 32 символов. Во избежании проблем с доступом
                избегайте использования руских буков.';
            } elseif (!$this->_comparePassword($post['password'], $post['password_2'])) {
                $this->message = 'Пароли должны быть одинаковыми';
            } else {
                $this->success = true;
                $this->message = 'Поздравляем с успешной регистрацией. Теперь проверьте вашу почту.';

                $confirmKey = md5(serialize($post) . time() . microtime());

                $this->_sendConfirmedEmail($this->_trimmer($post['nickname']), $post['email'], $confirmKey);
                //replace
                $this->_createUser($post, $confirmKey);
            }
        }
    }

    public function login($post)
    {
        if (isset($post['email']) && isset($post['password'])) {
            if (!$this->_isEmailInUse($post['email'])) {
                $this->message = 'Пользователь с таким E-mail не найден';
            } elseif ($this->getPasswordByEmail($post['email']) != Hasher::hashe($post['password'])) {
                $this->message = 'Не правильный пароль';
            } elseif ($this->getConfirmedByEmail($post['email']) != 1) {
                $this->message = 'Ваш аккаунт одидает подтверждения.
                Для завершения регистрации перейдите по ссылке, которую мы отправили вам на указанный почтовый ящик.';
            } else {
                $this->_autorizeUser($post['email']);

                $this->success = true;
            }
        }
    }

    public function recovery($email) {
        $result = $this->getConfirmedByEmail($email);

        if ($result) {
            $this->success = true;

            $this->message = 'По указанному E-mail отправлено письмо с инструкцией по востановлению пароля.
            Проверьте почту.';
            $nickname = $this->getNickNameByEmail($email);
            $recoveryKey = Hasher::hashe(time() . 'asd' . microtime(), 32);
            $this->_sendRecoveryEmail($nickname, $email, $recoveryKey);

            $this->updateRecoveryKeyByEmail($email, $recoveryKey);

            return true;
        } else {
            if ($result === null) {
                $this->message = 'Пользователь с данным E-mail не найден в системе';
            } else {
                $this->message = 'E-mail пользователя еще не подтвержден. Проверьте почту или зарегистрируйтесь заново.';
            }
            return false;
        }
    }

    public function setPassword($nickname, $post)
    {
        if (!$this->_validatePassword($post['password'])) {
            $this->message = 'Пароль должен быть от 8 до 32 символов';
            return false;
        } elseif ($post['password'] != $post['password2']) {
            $this->message = 'Пароли не совпадают';
            return false;
        } else {
            $password = Hasher::hashe($post['password']);
            $this->updatePasswordByNickname($nickname, $password);
            $this->message = 'Пароль успешно изменен';
            $this->success = true;
            return true;
        }
    }

    private function _trimmer($str): string
    {
        return trim(preg_replace('/ {2,}/', ' ', $str));
    }

    private function _validateNickname($nickname): bool
    {
        $_nick = $this->_trimmer($nickname);

        $len = iconv_strlen($_nick);

        return $len >= 4 && $len <= 32 && preg_match("/^[-_a-zA-Zа-яА-Я0-9\s]+$/ui", $_nick) ?: false;
    }

    private function _isNicknameInUse($nickname): bool
    {
        return Capsule::table('users')->where('nickname', '=', $nickname)->count();
    }

    private function _isEmailInUse($email): bool
    {
        return Capsule::table('users')->where('email', '=', $email)->count();
    }

    private function _comparePassword($pass1, $pass2): bool
    {
        return $pass1 == $pass2;
    }

    private function _createUser($post, $confirmKey)
    {



        $inviter_id = $_SESSION['inviter_id'] ?? 0;

        Capsule::table('users')->insert([
            'nickname' => $post['nickname'],
            'email' => $post['email'],
            'password' => Hasher::hashe($post['password']),
            'reg_time' => time(),
            'confirm_key' => $confirmKey,
            'inviter_id' => $inviter_id
        ]);
    }

    private function _autorizeUser($email)
    {
        $_SESSION['account']['user'] = $this->getIdByEmail($email);
    }

    private function _sendConfirmedEmail($nickname, $email, $confirmKey)
    {
        try {
            $this->mailer->addAddress($email, $nickname);     // Add a recipient
            $this->mailer->isHTML(true);                                  // Set email format to HTML
            $this->mailer->Subject = 'Не стоит отвечать на это письмо. Это робот.';
            $this->mailer->Body    = 'Здравствуйти <b>' . $nickname
                . '</b>! Для завершения регистрации перейдите по ссылке: <a href="' . HOST . '/confirm/' . $confirmKey
                . '">' . HOST . '/confirm/' . $confirmKey . '</a>';
            $this->mailer->AltBody = 'Здравствуйти ' . $nickname . '! Для завершения регистрации перейдите по ссылке: '
                . HOST . '/confirm/' . $confirmKey;

            $this->mailer->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }

    private function _sendRecoveryEmail($nickname, $email, $recoveryKey)
    {
        try {
            $this->mailer->addAddress($email, $nickname);     // Add a recipient
            $this->mailer->isHTML(true);                                  // Set email format to HTML
            $this->mailer->Subject = 'Не стоит отвечать на это письмо. Это робот.';
            $this->mailer->Body    = 'Здравствуйте <b>' . $nickname
                . '</b>! Для смены пароля перейдите по ссылке: <a href="' . HOST . '/set-password/' . $recoveryKey
                . '">' . HOST . '/set-password/' . $recoveryKey . '</a>';
            $this->mailer->AltBody = 'Здравствуйти ' . $nickname
                . '! Для завершения регистрации перейдите по ссылке: ' . HOST . '/confirm/' . $recoveryKey;

            $this->mailer->send();
//            echo 'Message has been sent';
        } catch (Exception $e) {
//            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }

    public function getNicknameById($id)
    {
        return Capsule::table('users')
            ->where('id', '=', $id)
            ->first('nickname')->nickname ?? null;
    }

    public function getPasswordByEmail($email)
    {
        return Capsule::table('users')
                ->where('email', '=', $email)
                ->first('password')->password ?? null;
    }

    public function getConfirmedByEmail($email)
    {
        return Capsule::table('users')
                ->where('email', '=', $email)
                ->first('confirmed')->confirmed ?? null;
    }

    public function getIdByEmail($email)
    {
        return Capsule::table('users')
                ->where('email', '=', $email)
                ->first('id')->id ?? null;
    }

    public function getIdByConfirmKey($key)
    {
        return Capsule::table('users')
                ->where('confirm_key', '=', $key)
                ->first('id')->id ?? null;
    }

    public function getNickNameByEmail($email)
    {
        return Capsule::table('users')
                ->where('email', '=', $email)
                ->first('nickname')->nickname ?? null;
    }

    public function getNickNameByRecoveryKey($recoveryKey)
    {
        return Capsule::table('users')
                ->where('recovery_key', '=', $recoveryKey)
                ->first('nickname')->nickname ?? null;
    }

    public function confirmUserById($id)
    {
        Capsule::table('users')
            ->where('id', '=', $id)
            ->update([
                'confirm_key' => '',
                'confirmed' => 1
            ]);
    }

    public function updatePasswordByNickname($nickname, $password)
    {
        Capsule::table('users')
            ->where('nickname', '=', $nickname)
            ->update([
                'recovery_key' => '',
                'password' => $password
            ]);
    }

    public function updateRecoveryKeyByEmail($email, $recoveryKey)
    {
        Capsule::table('users')
            ->where('email', '=', $email)
            ->update([
                'recovery_key' => $recoveryKey
            ]);
    }
}

