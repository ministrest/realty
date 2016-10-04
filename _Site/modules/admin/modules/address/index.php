<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Address;
use goodman\models\Locality;
use goodman\models\Region;
use goodman\models\Street;
use goodman\models\Sublocality;
use goodman\models\District;
use goodman\models\Building_description;

$module = 'address';
$pageTitle = 'Администрирование адресов';

$addresses = new Address();
$localities = new Locality();
$regions = new Region();
$streets = new Street();
$sublocalities = new Sublocality();
$districts = new District();

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

} elseif ($params['action'] == 'getHouse' or $params['param'] == 'getHouse') {
    $id_sublocality = $_POST['id_sublocality'];
    $id_street = $_POST['id_street'];
    $house_number = $_POST['house_number'];
    $address = $addresses->find(array('id_street=? AND id_sublocality=? AND house_number=?',$id_street,$id_sublocality,$house_number));
    
    if(isset($address[0]) and $address[0]->id_address>0) {
        $result['nonadmin_sublocality'] = $address[0]->nonadmin_sublocality;
    }
    echo json_encode($result);

} else {
    include HOMEDIR . '/modules/admin/modules/main/admin.top.tpl.php';
    if ($params['action'] == 'add') {
        if (isset($_POST['address'])) {

            $data = $addresses->checkPost($_POST['address']);
            if ($data != false) {
                if($addresses->checkAddressName($data)) {
                    $addresses->copyfrom($data);
                    if ($addresses->save()) $f3->reroute('/admin/address/list');
                } else {
                    $errors['region_name'] = 'Такой адрес уже есть';
                }
            } else {
                $errors['address'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'edit' and $params['param'] > 0) {
        $address = $addresses->find(array('id_address=?', $params['param']));
        $address = $address[0];
        $buildings = new Building_description();
        $building = $buildings->find(array('id_address=?', $params['param']));
        $building = $building[0];
        if (isset($_POST['address'])) {
            $data = $addresses->checkPost($_POST['address']);
            if ($data != false) {
                $address->copyfrom($data);
                if ($address->update()) $f3->reroute('/admin/address/list');
            } else {
                $errors['address'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'delete') {
        if ($addresses->erase(array('id_address=?', $params['param']))) $f3->reroute('/admin/address/list');
    }

    if ($params['action'] == 'addregion') {
        if (isset($_POST['region'])) {
            $data = $regions->checkPost($_POST['region']);
            if ($data != false) {
                if($regions->checkRegionName($data)) {
                    $regions->copyfrom($data);
                    if ($regions->save()) $f3->reroute('/admin/address/listregions');
                } else {
                    $errors['region_name'] = 'Такой регион уже есть';
                }
            } else {
                $errors['region'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'editregion' and $params['param'] > 0) {
        $regions = $regions->find(array('id_region=?', $params['param']));
        $region = $regions[0];
        if (isset($_POST['region'])) {
            $data = $region->checkPost($_POST['region']);
            if ($data != false) {
                $region->copyfrom($data);
                if ($region->update()) $f3->reroute('/admin/address/listregions');
            } else {
                $errors['region'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'deleteregion') {
        if ($regions->erase(array('id_region=?', $params['param']))) $f3->reroute('/admin/address/listregions');
    }

    if ($params['action'] == 'adddistrict') {
        if (isset($_POST['district'])) {

            $data = $districts->checkPost($_POST['district']);
            if ($data != false) {
                if($districts->checkDistrictName($data)) {
                    $districts->copyfrom($data);
                    if ($districts->save()) $f3->reroute('/admin/address/listdistricts');
                } else {
                    $errors['district_name'] = 'Такой округ уже есть';
                }
            } else {
                $errors['district'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'editdistrict' and $params['param'] > 0) {
        $districts = $districts->find(array('id_district=?', $params['param']));
        $district = $districts[0];
        if (isset($_POST['district'])) {
            $data = $district->checkPost($_POST['district']);
            if ($data != false) {
                $district->copyfrom($data);
                if ($district->update()) $f3->reroute('/admin/address/listdistricts');
            } else {
                $errors['district'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'deletedistrict') {
        if ($districts->erase(array('id_district=?', $params['param']))) $f3->reroute('/admin/address/listdistricts');
    }

    if ($params['action'] == 'addlocality') {
        if (isset($_POST['locality'])) {
            $data = $localities->checkPost($_POST['locality']);
            if ($data != false) {
                if($localities->checkLocalityName($data)) {
                    $localities->copyfrom($data);
                    if ($localities->save()) $f3->reroute('/admin/address/listlocalities');
                } else {
                    $errors['locality_name'] = 'Такой населенный пункт уже есть';
                }
            } else {
                $errors['locality'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'editlocality' and $params['param'] > 0) {
        $localities = $localities->find(array('id_locality=?', $params['param']));
        $locality = $localities[0];
        if (isset($_POST['locality'])) {
            $data = $locality->checkPost($_POST['locality']);
            if ($data != false) {
                $locality->copyfrom($data);
                if ($locality->update()) $f3->reroute('/admin/address/listlocalities');
            } else {
                $errors['locality'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'deletelocality') {
        if ($localities->erase(array('id_locality=?', $params['param']))) $f3->reroute('/admin/address/listlocalities');
    }

    if ($params['action'] == 'addsublocality') {
        if (isset($_POST['sublocality'])) {
            $data = $sublocalities->checkPost($_POST['sublocality']);
            if ($data != false) {
                if($sublocalities->checkSublocalityName($data)) {
                    $sublocalities->copyfrom($data);
                    if ($sublocalities->save()) $f3->reroute('/admin/address/listsublocalities');
                } else {
                    $errors['sublocality_name'] = 'Такой район уже есть';
                }
            } else {
                $errors['sublocality'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'editsublocality' and $params['param'] > 0) {
        $sublocalities = $sublocalities->find(array('id_sublocality=?', $params['param']));
        $sublocality = $sublocalities[0];
        if (isset($_POST['sublocality'])) {
            $data = $sublocality->checkPost($_POST['sublocality']);
            if ($data != false) {
                $sublocality->copyfrom($data);
                if ($sublocality->update()) $f3->reroute('/admin/address/listsublocalities');
            } else {
                $errors['sublocality'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'deletesublocality') {
        if ($sublocalities->erase(array('id_sublocality=?', $params['param']))) $f3->reroute('/admin/address/listsublocalities');
    }

    if ($params['action'] == 'addstreet') {
        if (isset($_POST['street'])) {
            $data = $streets->checkPost($_POST['street']);
            if ($data != false) {
                if($streets->checkStreetName($data)) {
                    $streets->copyfrom($data);
                    if ($streets->save()) $f3->reroute('/admin/address/liststreets');
                } else {
                    $errors['street_name'] = 'Такая улица уже есть';
                }
            } else {
                $errors['street'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'editstreet' and $params['param'] > 0) {
        $streets = $streets->find(array('id_street=?', $params['param']));
        $street = $streets[0];
        if (isset($_POST['street'])) {
            $data = $street->checkPost($_POST['street']);
            if ($data != false) {
                $street->copyfrom($data);
                if ($street->update()) $f3->reroute('/admin/address/liststreets');
            } else {
                $errors['street'] = 'Проверьте правильность введенных данных';
            }
        }
    }
    if ($params['action'] == 'deletestreet') {
        if ($streets->erase(array('id_street=?', $params['param']))) $f3->reroute('/admin/address/liststreets');
    }

    $f3->set('errors', $errors);
    if (isset($params['controller']) & isset($params['action'])) {
        include __DIR__ . '/' . $params['action'] . '.php';
    }
    include HOMEDIR . '/modules/admin/modules/main/admin.bottom.tpl.php';
}