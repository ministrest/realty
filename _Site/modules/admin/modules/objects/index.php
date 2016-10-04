<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Object_info;
use goodman\models\Renovation;
use goodman\models\Quality;
use goodman\models\Category_agent;
use goodman\models\Category_object;
use goodman\models\Lot_type;
use goodman\models\Images;
use goodman\models\Floor;
use goodman\models\Address;
use goodman\models\Advert_info;
use goodman\models\Building_description;

$module = 'objects';
$pageTitle = 'Администрирование объектов';
$objects = new Object_info();
$renovations = new Renovation();
$qualities = new Quality();
$category_agents = new Category_agent();
$lot_types = new Lot_type();
$addresses = new Address();
$floors = new Floor();
$adverts = new Advert_info();
$buildings = new Building_description();
$categories = new Category_object();
$errors = array();

if ($params['action'] == "addphoto") {
    $uploaddir = '/uploads/objects/';

    $file = $_POST['value'];
    $name = $_POST['name'];
// Получаем расширение файла
    $getMime = explode('.', $name);
    $mime = end($getMime);
// Выделим данные
    $data = explode(',', $file);

// Декодируем данные, закодированные алгоритмом MIME base64
    $encodedData = str_replace(' ', '+', $data[1]);
    $decodedData = base64_decode($encodedData);

// создать произвольное имя
    $randomName = substr_replace(sha1(microtime(true)), '', 12) . '.' . $mime;

// Создаем изображение на сервере
    $uploadfile = ROOTDIR . $uploaddir . $randomName;
    if (file_put_contents($uploadfile, $decodedData)) {
        // Записываем данные изображения в БД
        $image = new Images();
        $image->img_resize($uploadfile, $uploadfile, 1000, 800);

        $obj_id = $params['param'];
        $image->id_object = $obj_id;
        $image->catalog = $uploaddir;
        $image->filename = $randomName;
        if ($image->save()) {
            $path = ROOTDIR . '/' . $uploaddir . $randomName;
            $path_thumb = ROOTDIR . '/' . $uploaddir . 'thumbs/' . $randomName;
            $image->img_resize($path, $path_thumb, 250, 235);
            echo $randomName . ":загружен успешно";
            return true;
        }
    } else {
        // Показать сообщение об ошибке, если что-то пойдет не так.
        return "Что-то пошло не так. Убедитесь, что файл не поврежден!";
    }
} else {
    include HOMEDIR . '/modules/admin/modules/main/admin.top.tpl.php';
    if ($params['action'] == 'add') {
        if (isset($_POST['object'])) {
            $data = $objects->checkPost($_POST['object']);
            if ($data) {
                $objects->copyfrom($data);
                if ($objects->save()) $f3->reroute('/admin/objects/list');
            } else {
                $object = new Object_info();
                $object->copyfrom($_POST['object']);
                $errors = $f3->get('errors');
            }
        }
    }

    if ($params['action'] == 'edit' and $params['param'] > 0) {
        $object = $objects->find(array('id_object=?', $params['param']));
        $object = $object[0];
        $obj_images = $object->getImages();

        if (isset($_POST['object'])) {
            $data = $objects->checkPost($_POST['object']);
            if ($data) {
                $object->copyfrom($data);
                if ($object->update()) $f3->reroute('/admin/objects/list');
            } else {
                $errors = $f3->get('errors');
            }
        }
    }

    if ($params['action'] == 'delete') {
        $images = new Images();
        $images = $images->find(array('id_object=?', $params['param']));
        foreach ($images as $image) {
            $file = ROOTDIR . $image->catalog . $image->filename;
            unlink($file);
            $file = ROOTDIR . $image->catalog . 'thumbs/' . $image->filename;
            unlink($file);
        }
        $adverts->erase(array('id_object=?', $params['param']));
        if ($objects->erase(array('id_object=?', $params['param']))) {
            $f3->reroute('/admin/objects/list');
        } 
    }

    if ($params['action'] == 'deleteimg') {
        $images = new Images();
        $image = $images->find(array('id_image=?', $params['param']));
        $image = $image[0];
        $file = ROOTDIR . $image->catalog . $image->filename;
        unlink($file);
        $file = ROOTDIR . $image->catalog . 'thumbs/' . $image->filename;
        unlink($file);
        $obj_id = $image->id_object;
        if ($images->erase(array('id_image=?', $params['param']))) $f3->reroute('/admin/objects/edit/' . $obj_id);
    }

    $f3->set('errors', $errors);

    if (isset($params['controller']) & isset($params['action']) & ($params['action'] != 'addphoto')) {
        if ($params['action'] == 'edit') {
            $user = $users->find(array('hash=? and id_user=?', $_COOKIE['goodman']['hash'], (int)$_COOKIE['goodman']['id']));
            $user_group = $user[0]['id_group'];
            if ((isset($object) and $object->user_id == $_COOKIE['goodman']['id']) or $user_group==2) {
                include __DIR__ . '/edit.php';
            } else {
                include __DIR__ . '/view.php';
            }
        } else {
            include __DIR__ . '/' . $params['action'] . '.php';
        }
    }
    include HOMEDIR . '/modules/admin/modules/main/admin.bottom.tpl.php';
}