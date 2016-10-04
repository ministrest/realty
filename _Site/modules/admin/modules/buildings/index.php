<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Building_description;
use goodman\models\Building_state;
use goodman\models\Address;
use goodman\models\Building_type;

$module = 'buildings';
$pageTitle = 'Администрирование зданий';
$building = new Building_description();
$building_states = new Building_state();
$building_types = new Building_type();
$addresses = new Address();
$errors = array();
$f3->set('errors', $errors);
include HOMEDIR . '/modules/admin/modules/main/admin.top.tpl.php';
if ($params['action'] == 'add') {
    if($params['param'] > 0) $building->id_address = $params['param'];
    if (isset($_POST['building'])) {
        $data = $building->checkPost($_POST['building']);
        if ($data) {
            if($building->checkBuildingName($data)) {
                $building->copyfrom($data);
                if ($building->save()) $f3->reroute('/admin/buildings/list');
            } else {
                $errors['building_name'] = 'Такое здание уже есть';
            }
        } else {
            $building = new Building_description();
            $building->copyfrom($_POST['building']);
            $errors = $f3->get('errors');
        }
    }
}

if ($params['action'] == 'edit' and $params['param'] > 0) {
    $building = $building->find(array('id_building=?', $params['param']));
    $building = $building[0];

    if (isset($_POST['building'])) {
        $data = $building->checkPost($_POST['building']);
        if ($data) {
            $building->copyfrom($data);
            if ($building->update()) $f3->reroute('/admin/buildings/list');
        } else {
            $errors = $f3->get('errors');
        }
    }
}

if ($params['action'] == 'delete') {
    if ($building->erase(array('id_building=?', $params['param']))) $f3->reroute('/admin/buildings/list');
}

$f3->set('errors', $errors);
if (isset($params['controller']) & isset($params['action'])) {
    if ($params['action'] == 'edit') {
        $user = $users->find(array('hash=? and id_user=?', $_COOKIE['goodman']['hash'], (int)$_COOKIE['goodman']['id']));
        $user_group = $user[0]['id_group'];
        if ($user_group!=4) {
            include __DIR__ . '/edit.php';
        } else {
            include __DIR__ . '/view.php';
        }
    } else {
        include __DIR__ . '/' . $params['action'] . '.php';
    }
}
include HOMEDIR . '/modules/admin/modules/main/admin.bottom.tpl.php';