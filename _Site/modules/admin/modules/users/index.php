<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Users;
use goodman\models\Groups;

$module = 'users';
setcookie("goodman[module]", $module, time() + 60 * 60 * 24 * 30);
$pageTitle = 'Администрирование пользователей';
$users = new Users();
$agents = new \goodman\models\Sales_agent_info();
$errors = array();
$f3->set('errors', $errors);

include HOMEDIR . '/modules/admin/modules/main/admin.top.tpl.php';

if ($params['action'] == 'edit' and $params['param'] > 0) {
    $user = $users->find(array('id_user=?', $params['param']));
    $user = $user[0];
    if (isset($_POST['email'])) {
        if($users->saveFromPost($_POST, $user, $params['action'])){
            if($user->id_user==$_COOKIE['goodman']['id']){
                setcookie("goodman[id]", "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie("goodman[hash]", "", time() - 3600 * 24 * 30 * 12, "/");
                $_SESSION = array(); //Очищаем сессию
                $f3->reroute('/admin');
            }
            $f3->reroute('/admin/users/list');
        }
    }

}

if ($params['action'] == 'add') {
    if (isset($_POST['email'])) {
        if($users->saveFromPost($_POST, $users, $params['action'])){
            $f3->reroute('/admin/users/list');
        } else{
            
        }
    }
}
if ($params['action'] == 'delete') {
    $user = $users->find(array('id_user=?', $params['param']));
    $user = $user[0];
    if(isset($user->avatar) and !empty($user->avatar)) {
        $file = ROOTDIR . "/inc/i/avatar/" . $user->avatar;
        unlink($file);
    }
    if ($users->erase(array('id_user=?', $params['param']))) {
        $f3->reroute('/admin/users/list');
    }
}

if (isset($params['controller']) & isset($params['action'])) {
    $groups = new Groups();
    include __DIR__ . '/' . $params['action'] . '.php';
}
include HOMEDIR . '/modules/admin/modules/main/admin.bottom.tpl.php';