<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Images;

$module = 'images';
$pageTitle = 'Администрирование картинок';
$images = new Images();

$errors = array();
$f3->set('errors', $errors);

function upload() {
    if ( ! empty($_FILES['imagefile']['tmp_name']) && !$_FILES['imagefile']['error'] && $_FILES['imagefile']['size']>0) {
        return $this->images->upload($_FILES['imagefile']);
    } else {
        return 'error';
    }
}

function uploadphoto() {
    if ( ! empty($_FILES['imagefile']['tmp_name']) && !$_FILES['imagefile']['error'] && $_FILES['imagefile']['size']>0) {
        return $this->images->uploadphoto($_FILES['imagefile']);
    } else {
        $this->response->body = 'error';
    }
}

if ($params['action'] == 'delete') {
    $image = $images->find(array('id_image=?', $params['param']));
    $obj_id = $image[0]->id_object;
    if ($images->erase(array('id_image=?', $params['param']))) $f3->reroute('/admin/objects/edit/'.$obj_id);
}