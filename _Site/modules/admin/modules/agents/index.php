<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Users;
use goodman\models\Groups;

$module = 'agents';
setcookie("goodman[module]", $module, time() + 60 * 60 * 24 * 30);
$pageTitle = 'Администрирование пользователей';
$users = new Users();
$agents = new \goodman\models\Sales_agent_info();
$errors = array();
$f3->set('errors', $errors);

include HOMEDIR . '/modules/admin/modules/main/admin.top.tpl.php';

if ($params['action'] == 'editagent' and $params['param'] > 0) {
    $agent = $agents->find(array('id_sales_agent=?', $params['param']));
    $agent = $agent[0];
    if (isset($_POST['agent'])) {
        $data = $agents->checkPost($_POST['agent']);
        if ($data) {
            $agent->copyfrom($data);
            if ($agent->save()){
                if ($users->checkAccess('users', $f3)) $f3->reroute('/admin/agents/listagent');
                if ($users->checkAccess('agents', $f3)) $f3->reroute('/admin/agents/contacts');
            }
        } else {
            $errors['agent'] = 'Проверьте правильность введенных данных';
        }
    }
}

if ($params['action'] == 'addagent') {
    if (isset($_GET['user']) and $_GET['user']>0) {
        $agent = new \goodman\models\Sales_agent_info();
        $agent->id_user = $_GET['user'];
    }
    if (isset($_POST['agent'])) {
        $data = $agents->checkPost($_POST['agent']);
        if ($data) {
            $agents->copyfrom($data);
            if ($agents->save()) $f3->reroute('/admin/agents/listagent');
        } else {
            $errors['agent'] = 'Проверьте правильность введенных данных';
        }
    }
}
if ($params['action'] == 'deleteagent') {
    if ($agents->erase(array('id_sales_agent=?', $params['param']))) $f3->reroute('/admin/agents/listagent');
}

if (isset($params['controller']) & isset($params['action'])) {
    $groups = new Groups();
    include __DIR__ . '/' . $params['action'] . '.php';
}
include HOMEDIR . '/modules/admin/modules/main/admin.bottom.tpl.php';