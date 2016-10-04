<?php
namespace goodman\models;
use goodman\helpers;

class Users extends Model {

    public $pk = "id_user";
    public $table = "users";

    public function getGroup($id_group) {
        $groups = new Groups();
        $result = $groups->getAttribute($id_group,"name");
        if (!empty($result)) return $result;
    }
    
    public function getAgent() {
        $agents = new Sales_agent_info();
        $agent = $agents->find(array('id_user=?', $this->id_user));
        if(isset($agent[0])){
            return $agent[0];
        }
        return false;
    }
    public function getAvatar()
    {
        if (isset($this->avatar) and !empty($this->avatar)) {
            return "http://" . $_SERVER['SERVER_NAME'] . "/inc/i/avatar/" . $this->avatar;
        } 
        return "http://" . $_SERVER['SERVER_NAME'] . "/inc/i/user.jpg";
    }
    public function checkAccess($controller,$f3) {
        $modules = $f3->get('modules');
        $modules = $modules[$controller];

        if (!(is_array($modules))) $modules = array(0 => $modules);
        if (in_array($_COOKIE['goodman']['group'], $modules)){
            return true;
        }
        return false;
    }

    public function saveFromPost($data, $user, $action)
    {
        $f3 = \Base::instance();
        $errors = array();
        $auth = new helpers\Authentification($f3);
        $images = new Images();
        
        $data['email'] = $this->checkText($data['email']);
        if ($auth->checkEmail($data['email'],$action)) {
            $email = $data['email'];
        } else {
            $errors['email'] = 'Проверьте правильность введенного email адреса';
        }
        $data['login'] = $this->checkText($data['login']);
        if ($auth->checkLogin($data['login'],$action)) {
            $login = $data['login'];
        } else {
            $errors['login'] = 'Проверьте правильность введенного логина';
        }
        $data['password'] = $this->checkText($data['password']);
        $data['password2'] = $this->checkText($data['password2']);
        if($data['password']==$data['password2']) {
            if ($auth->checkPassword($data['password'])) {
                $pw = md5($data['password']);
            } else {
                $errors['password'] = 'Формат пароля неверный';
            }
        } else {
            $errors['password2'] = 'Неверно. Введите пароль ещё раз';
        }

        if (!empty($_FILES['userfile']['name'])) {
            if($images->uploadImage($_FILES['userfile'])==false) {
                $errors['image'] = 'Проблема с загрузкой изображения';
            } else {
                if($action == 'edit' and !empty($user->avatar)){
                    $file = ROOTDIR . "/inc/i/avatar/" . $user->avatar;
                    if(is_file($file)) {
                        unlink($file);
                    }
                }
            }
        }

        if (count($errors) == 0) {
            $user->login = $login;
            $user->email = $email;
            $user->id_group = $data['users_group'];
            $user->password = $pw;
            if (!empty($_FILES['userfile']['name'])) $user->avatar = basename($_FILES['userfile']['name']);
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $user->created = $date;
            if (($action == 'add')? $user->save() : $user->update()) {
                return true;
            }
        } else {
            $f3->set('errors', $errors);
            return false;
        }
    }
}
