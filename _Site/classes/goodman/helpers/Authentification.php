<?php
namespace goodman\helpers;
use goodman\models\Users;

/**
 * Class Auth
 * Helper для формы авторизации админ панели
 * @package goodman\helpers
 */
class Authentification
{

    protected $f3;
   // protected $email;
    protected $pw;
    protected $user;
    protected $login;
    protected $errors = array();
    protected $check = false;


    /**
     * Auth constructor.
     * @param \Base $f3 экземпляр FatFree
     */
    public function __construct($f3)
    {
        $this->f3 = $f3;
    }

    /**
     * Auth create.
     */
    public function createAuth()
    {
        $users = new Users();
        //$auth = new \Auth($users, array('id' => 'email', 'pw' => 'password'));
        $auth = new \Auth($users, array('id' => 'login', 'pw' => 'password'));
        return $auth;
    }

    /**
     * Auth create.
     * @param $data
     */
    public function checkAndLogin($data)
    {
        $auth = $this->createAuth();
        if ($this->checkPassword($data['password'])) {
            $this->pw = md5($data['password']);
        } else {
            $this->errors['password'] = 'Формат пароля неверный';
        }

        /* let`s check email address */
        /*if ($this->checkEmail($data['email'])) {
            $this->email = $data['email'];
        } else {
            $this->errors['email'] = 'Проверьте правильность введенного email адреса';
        }*/
        /* let`s check login */

        if ($this->checkLoginAuth($data['login'])) {
            $this->login = $data['login'];

        } else {
            $this->errors['login'] = 'Проверьте правильность введенного login адреса';
        }
        $this->check = $auth->login($this->login, $this->pw); // returns true on successful login
        if ($this->check == false) {
            $this->errors['password'] = 'Введен неверный пароль';
        }
    }

    /**
     * Auth create.
     * @param $cookie
     */
    public function checkCookies($cookie)
    {
        if (isset($cookie)) {
            $users = new Users();
            $this->user = $users->find(array('hash=? and id_user=?', $cookie['hash'], (int)$cookie['id']));
            if ($this->user == null) {
                setcookie("goodman[id]", "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie("goodman[group]", "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie("goodman[hash]", "", time() - 3600 * 24 * 30 * 12, "/");
            } else {
                $this->check = true;
            }
        } else {
            $this->errors['cookie'] = 'Включите cookie';
        }
    }

    /* генерация случайной строки */
    public function generateCode($length = 6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }

    public function checkEmail($checkmail, $action = '')
    {
        if (!empty($checkmail) and (strlen($checkmail) > 5)) {
            $pos = strpos($checkmail, '@');
            if ($pos > 0) {
                if ($action == 'add') {
                    $users = new Users();
                    $this->user = $users->find(array('email=?', $checkmail));
                    if (count($this->user) > 0) {
                        return false;
                    }
                }
                return true;
            }
        }
        return false; /* empty email or too short */
    }

    public function checkPassword($password)
    {
        if (!empty($password) and (strlen($password) > 5)) {
            return true;
        }
        return false; /* empty or too short */
    } 
    
    public function checkLoginAuth($login)
    {
        if (!empty($login)) {
            return true;
        }
        return false; /* empty or too short */
    }

    public function checkLogin($checkLogin, $action = '')
    {
        if (empty($checkLogin) or (strlen($checkLogin) < 4) or (!preg_match("/^[a-zA-Z0-9]{3,30}$/", $checkLogin))) {
            return false;
        }
        if ($action == 'add') {
            $users = new Users();
            $this->user = $users->find(array('login=?', $checkLogin));
            if (count($this->user) > 0) {
                return false;
            }
        }
        return true;

    }
    public function checkUser()
    {
        $user = $this->user;
        if (!isset($user[0]['email'])) {
            $hash = md5($this->generateCode(10));
            $users = new Users();
            $user = $users->find(array('login=?', $this->login));
            $user = $user[0];
            $user->hash = $hash;
            $user->update();
            setcookie("goodman[id]", $user->id_user, time() + 60 * 60 * 24 * 30);
            setcookie("goodman[group]", $user->getGroup($user->id_group), time() + 60 * 60 * 24 * 30);
            setcookie("goodman[hash]", $hash, time() + 60 * 60 * 24 * 30);
        }
    }
    /**
     * Возвращает количество объявлений по категориям
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
    /**
     * Возвращает количество объявлений по категориям
     * @return mixed
     */
    public function getCheck()
    {
        return $this->check;
    }
}