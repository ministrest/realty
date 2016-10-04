<?php
use goodman\models\Advert_info;
$page = $f3->get('pageHelper');
$errors = array();
$f3->set('errors', $errors);

$module = 'buy';
setcookie("goodman[module]", $module, time() + 60 * 60 * 24 * 30);
$page->css[] = '/inc/jscss/fotorama/fotorama.css';
$page->js[]  = '/inc/jscss/fotorama/fotorama.js';
$page->js[]  = '/inc/jscss/ionSlider/js/ion.rangeSlider.min.js';
$page->printHead();
include HOMEDIR . '/inc/tpl/header.tpl.php';
include HOMEDIR . '/inc/tpl/navigation.tpl.php';
if(isset($params['param']) and $params['param']>0){
	$adverts = new Advert_info();
	$advert = $adverts->find(array('id_advert=?', $params['param']));
	$advert = $advert[0];
	$object = $advert->getObject();
	include __DIR__ .  '/view.tpl.php';
}

if(isset($params['param']) and $params['param']>0){
	$adverts = new Advert_info();
	$advert = $adverts->find(array('id_advert=?', $params['param']));
	$advert = $advert[0];
	$object = $advert->getObject();
	$page->pageTitle = "Продается ".(($advert->id_category == '2' and $advert->getRooms() > 0) ? $advert->getRooms() .'-комнатная квартира ' : $advert->getCategoryObject()) . ' ';
}
include HOMEDIR . '/inc/tpl/sider_right.tpl.php';
include HOMEDIR . '/inc/tpl/footer.tpl.php';