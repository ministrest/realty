<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Object_info;
use goodman\models\Advert_info;
use goodman\models\Category_object;
use goodman\models\Currency;
use goodman\models\Unit;
use goodman\models\Deal_status;
use goodman\models\Users;
use goodman\models\Building_description;
use goodman\models\Address;
use goodman\models\Locality;
use goodman\models\Region;
use goodman\models\Street;
use goodman\models\Sublocality;
use goodman\models\District;
use goodman\models\Building_state;
use goodman\models\Building_type;
use goodman\models\Renovation;
use goodman\models\Quality;
use goodman\models\Category_agent;
use goodman\models\Lot_type;
use goodman\models\Images;
use goodman\models\Floor;
use goodman\models\Property_type;

$module = 'adverts';
$pageTitle = 'Администрирование объявлений';
$objects = new Object_info();
$adverts = new Advert_info();
$categories = new Category_object();
$currencies = new Currency();
$units = new Unit();
$deal_statuses = new Deal_status();
$buildings = new Building_description();
$addresses = new Address();
$localities = new Locality();
$regions = new Region();
$streets = new Street();
$sublocalities = new Sublocality();
$districts = new District();
$building_states = new Building_state();
$building_types = new Building_type();
$renovations = new Renovation();
$qualities = new Quality();
$category_agents = new Category_agent();
$lot_types = new Lot_type();
$floors = new Floor();
$property_types = new Property_type();

$errors = array();
$f3->set('errors', $errors);
if ($params['action'] == 'getSublocality' or $params['param'] == 'getSublocality') {
    $id_locality = $_POST['id_locality'];
    $sublocalities = $sublocalities->find(array('id_locality=?', $id_locality),array('order'=>'sublocality_name'));
    $result['loc'][0]['id_sublocality'] = 0;
    $result['loc'][0]['sublocality_name'] = 'Не определено';
    foreach ($sublocalities as $key => $sublocality) {
        $result['loc'][$key + 1]['id_sublocality'] = $sublocality->id_sublocality;
        $result['loc'][$key + 1]['sublocality_name'] = $sublocality->sublocality_name;
    }
    $streets = $streets->find(array('id_locality=?', $id_locality),array('order'=>'street_name'));
    $result['str'][0]['street_id'] = 0;
    $result['str'][0]['street_name'] = 'Не определено';
    foreach ($streets as $key => $street) {
        $result['str'][$key + 1]['street_id'] = $street->id_street;
        $result['str'][$key + 1]['street_name'] = $street->street_name;
    }

    echo json_encode($result);

} elseif ($params['action'] == 'getBuilding' or $params['param'] == 'getBuilding') {
    $id_sublocality = $_POST['id_sublocality'];
    $id_street = $_POST['id_street'];
    $house_number = $_POST['house_number'];
    $address = $addresses->find(array('id_street=? AND id_sublocality=? AND house_number=?', $id_street, $id_sublocality, $house_number));
    $result['building'] = array();
    $result['id_address'] = '';
    $result['nonadmin_sublocality'] = '';
    $result['building'] = '';
    /*$result['advert'] = array();
    $result['object'] = array();*/
    if (isset($address[0]) and $address[0]->id_address > 0) {
        $result['id_address'] = $address[0]->id_address;
        $result['nonadmin_sublocality'] = $address[0]->nonadmin_sublocality;
        $building = $address[0]->getBuilding();
        if (isset($building)) $result['building'] = $building->cast();
        /*$object = $address[0]->getObject();
        if($object->id_object>0){
            $advert = $object->getAdvert();
            $result['advert'] = $advert->cast();
            $result['object'] = $object->cast();
        }*/
    }

    echo json_encode($result);


} else {
    include HOMEDIR . '/modules/admin/modules/main/admin.top.tpl.php';

    if ($params['action'] == 'add') {
        if (isset($_POST['advert'])) {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $_POST['advert']['creation_date'] = $date;
            $_POST['advert']['last_update_date'] = $date;
            if(!isset($_POST['advert']['user_id']) or empty($_POST['advert']['user_id'])) {
                $_POST['advert']['user_id'] = (int)$_COOKIE['goodman']['id'];
            }
            $data = $adverts->checkPost($_POST['advert']);
            if ($data != false) {
                $object = $objects->find(array('id_object=?',$data["id_object"]));
                if($object[0]->user_id != $data['user_id']){
                    $object[0]->user_id = $data['user_id'];
                    $object[0]->update();
                }
                $adverts->copyfrom($data);
                if ($adverts->save()) {
                    $f3->reroute('/admin/adverts/list');
                }
            }
            $advert = new Advert_info();
            $advert->copyfrom($_POST['advert']);
            $errors = $f3->get('errors');

        }
    }

    if ($params['action'] == 'addall') {
        if (isset($_GET['address']) and $_GET['address'] > 0) {
            $address = $addresses->findByPk($_GET['address']);
            $address = $address[0];
            $building = $buildings->find(array('id_address=?', $_GET['address']));
            $building = $building[0];
            if (!empty($address) and empty($building)) {
                $building = new Building_description();
                $building->id_address = $_GET['address'];
            }
            if (isset($_GET['object']) and $_GET['object'] > 0) {
                $object = $objects->find(array('id_object=?', $_GET['object']));
                $object = $object[0];
                $obj_images = $object->getImages();
                if(empty($object)) {
                    $object = new Object_info();
                } else {
                    $advert = $adverts->find(array('id_object=?', $_GET['object']));
                    $advert = $advert[0];
                    if(empty($advert)) $advert = new Advert_info();
                }
            } else {
                if (!empty($address) and !empty($building)) {
                    $object = new Object_info();
                    $object->id_address = $_GET['address'];
                }
            }
        }
        if (isset($_POST['address'])) {
            $data = $addresses->checkPost($_POST['address']);
            if ($data != false) {
                if (isset($_POST['address']['id_address']) and $_POST['address']['id_address']>0) {
                    $address = $addresses->findByPk($_POST['address']['id_address']);
                    $address = $address[0];
                    $address->copyfrom($data);
                    if ($address->update()) $f3->reroute('/admin/adverts/addall?address=' . $address->id_address);
                } else {
                    if ($addresses->checkAddressName($data)) {
                        $addresses->copyfrom($data);
                        if ($addresses->save()) $f3->reroute('/admin/adverts/addall?address=' . $addresses->id_address);
                    } else {
                        $errors['region_name'] = 'Такой адрес уже есть';
                    }
                }

            }
            $errors['address'] = 'Проверьте правильность введенных данных';
        }
        if (isset($_POST["building"])) {
            $data = $buildings->checkPost($_POST['building']);
            if ($data) {
                if (isset($_POST['building']['id_building']) and $_POST['building']['id_building']>0) {
                    $building = $buildings->find(array('id_building=?', $_POST['building']['id_building']));
                    $building = $building[0];
                    $building->copyfrom($data);
                    if ($building->update()) $f3->reroute('/admin/adverts/addall?address=' . $building->id_address);
                } else {
                    if ($buildings->checkBuildingName($data)) {
                        $buildings->copyfrom($data);
                        if ($buildings->save()) $f3->reroute('/admin/adverts/addall?address=' . $buildings->id_address);
                    } else {
                        $errors['building_name'] = 'Такое здание уже есть';
                    }
                }
            }
            if(!isset($building)){
                $building = new Building_description();
                $building->copyfrom($_POST['building']);
            }
            if(!isset($address)) {
                $address = $addresses->find(array('id_address', $_POST["building"]['id_address']));
                $address = $address[0];
            }

            $errors['building'] = $f3->get('errors');
        }
        if (isset($_POST['object'])) {
            $data = $objects->checkPost($_POST['object']);
            if ($data) {
                if (isset($_POST['object']['id_object']) and $_POST['object']['id_object']>0) {
                    $object = $objects->find(array('id_object=?', $_POST['object']['id_object']));
                    $object = $object[0];
                    $object->copyfrom($data);
                    if ($object->update()) $f3->reroute('/admin/adverts/addall?address=' . $object->id_address.'&object=' . $object->id_object);
                } else {
                    $objects->copyfrom($data);
                    if ($objects->save()) $f3->reroute('/admin/adverts/addall?address=' . $objects->id_address.'&object=' . $objects->id_object);
                }
            }
            if(!isset($object)){
                $object = new Object_info();
                $object->copyfrom($_POST['object']);
            }
            if(!isset($address)) {
                $address = $addresses->find(array('id_address', $_POST["object"]['id_address']));
                $address = $address[0];
                $building = $buildings->find(array('id_address', $_POST["object"]['id_address']));
                $building = $building[0];
            }
            $errors['object'] = $f3->get('errors');

        }
        if (isset($_POST['advert'])) {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $_POST['advert']['creation_date'] = $date;
            $_POST['advert']['last_update_date'] = $date;
            if(!isset($_POST['advert']['user_id']) or empty($_POST['advert']['user_id'])) {
                $_POST['advert']['user_id'] = (int)$_COOKIE['goodman']['id'];
            }
            $data = $adverts->checkPost($_POST['advert']);
            if ($data != false) {
                if (isset($_POST['advert']['id_advert']) and $_POST['advert']['id_advert']>0) {
                    $advert = $adverts->find(array('id_advert=?', $_POST['advert']['id_advert']));
                    $advert = $advert[0];
                    $object = $objects->find(array('id_object=?', $data["id_object"]));
                    $object[0]->user_id = $data['user_id'];
                    $advert->copyfrom($data);
                    if ($advert->update()){
                        $object[0]->update();
                        $f3->reroute('/admin/adverts/list');
                    }
                } else {
                    $adverts->copyfrom($data);
                    $object = $objects->find(array('id_object=?',$data["id_object"]));
                    if($object[0]->user_id != $data['user_id']) {
                        $object[0]->user_id = $data['user_id'];
                        $object[0]->update();
                    }
                    if ($adverts->save())  $f3->reroute('/admin/adverts/list');
                }
            }
            if(!isset($advert)) {
                $advert = new Advert_info();
                $advert->copyfrom($_POST['advert']);
            }
            if(!isset($object)) {
                $object = $objects->find(array('id_object=?',$_POST['advert']["id_object"]));
                $object = $object[0];
                $address = $addresses->find(array('id_address', $object->id_address));
                $address = $address[0];
                $building = $buildings->find(array('id_address', $object->id_address));
                $building = $building[0];
            }
            $errors['advert'] = $f3->get('errors');
        }
    }

    if ($params['action'] == 'edit' and $params['param'] > 0) {
        $advert = $adverts->find(array('id_advert=?', $params['param']));
        $advert = $advert[0];

        $building = $advert->getBuilding();

        if (isset($_POST['advert'])) {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $_POST['advert']['last_update_date'] = $date;
            $data = $adverts->checkPost($_POST['advert']);
            if ($data != false) {
                $object = $objects->find(array('id_object=?',$data["id_object"]));
                if($object[0]->user_id != $data['user_id']){
                    $object[0]->user_id = $data['user_id'];
                    $object[0]->update();
                }
                $advert->copyfrom($data);
                if ($advert->update()) $f3->reroute('/admin/adverts/list');
            } else {
                $errors = $f3->get('errors');
            }
        }
    }

    if ($params['action'] == 'delete') {
        if ($adverts->erase(array('id_advert=?', $params['param']))) $f3->reroute('/admin/adverts/list');
    }
    if ($params['action'] == 'list') {
        $users = new Users();
    }
    $f3->set('errors', $errors);
    if (isset($params['controller']) & isset($params['action'])) {
        if ($params['action'] == 'edit') {
            $user = $users->find(array('hash=? and id_user=?', $_COOKIE['goodman']['hash'], (int)$_COOKIE['goodman']['id']));
            $user_group = $user[0]['id_group'];
            if ((isset($advert) and $advert->user_id == $_COOKIE['goodman']['id']) or $user_group == 2) {
                include __DIR__ . '/edit.php';
            } else {
                $f3->reroute('/buy/view/' . $params['param']);
            }
        } else {
            include __DIR__ . '/' . $params['action'] . '.php';
        }
    }
    include HOMEDIR . '/modules/admin/modules/main/admin.bottom.tpl.php';
}