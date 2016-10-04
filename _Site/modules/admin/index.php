<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Users;
use goodman\helpers\Authentification;
use goodman\models\Sales_agent_info;

$page = $f3->get('pageHelper');
$module = 'admin';
$pageTitle = 'Админка  GOODMAN';

$users = new Users();
$agents = new Sales_agent_info();
$auth_check = new Authentification($f3);

if (isset($_POST['submit'])) {
    $auth_check->checkAndLogin($_POST);
} else {
    $auth_check->checkCookies($_COOKIE['goodman']);
}
$errors = $auth_check->getErrors();
$f3->set('errors', $errors);
$check = $auth_check->getCheck();

if ($check == false) {
    include __DIR__ . '/modules/main/login.tpl.php';
} else {
    $auth_check->checkUser();
    if (!isset($_COOKIE['goodman']['id'])) {
        $f3->reroute('/admin');
    }

    if (isset($params['controller']) & isset($params['action'])) {
        if ($params['controller'] == 'admin' and $params['action'] == 'logout') {
            include __DIR__ . '/logout.php';
        }
        if ($users->checkAccess($params['controller'], $f3)) {
            include __DIR__ . '/modules/' . $params['controller'] . '/index.php';
        } else {
            include __DIR__ . '/modules/main/admin.top.tpl.php';
            include __DIR__ . '/modules/main/admin.404.tpl.php';
            include __DIR__ . '/modules/main/admin.bottom.tpl.php';
        }
    } else {
        include __DIR__ . '/modules/main/admin.top.tpl.php';
        include __DIR__ . '/modules/main/admin.dashboard.tpl.php';
        include __DIR__ . '/modules/main/admin.bottom.tpl.php';
    }
}

