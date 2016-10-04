<?php
/** @var \NMG\Page\Page $page */
use goodman\models\Advert_info;
use goodman\models\Category_object;
use goodman\models\Building_type;

$page = $f3->get('pageHelper');
$errors = array();
$f3->set('errors', $errors);

$module = 'buy';
setcookie("goodman[module]", $module, time() + 60 * 60 * 24 * 30);
$search = array();

$categories     = new Category_object();
$building_types = new Building_type();


$page->css[] = '/inc/jscss/ionSlider/css/normalize.css';
$page->css[] = '/inc/jscss/ionSlider/css/ion.rangeSlider.css';
$page->css[] = '/inc/jscss/ionSlider/css/ion.rangeSlider.skinHTML5.css';
$page->css[] = '/inc/jscss/fotorama/fotorama.css';
$page->js[]  = '/inc/jscss/fotorama/fotorama.js';
$page->js[]  = '/inc/jscss/ionSlider/js/ion.rangeSlider.min.js';
$page->js[]  = '/inc/jscss/contact.js';
$page->pageTitle = "Покупка недвижимости в Саратове ";


$page->printHead();
include HOMEDIR . '/inc/tpl/header.tpl.php';
include HOMEDIR . '/inc/tpl/navigation.tpl.php';
include __DIR__ . '/index.tpl.php';
include HOMEDIR . '/inc/tpl/sider_right.tpl.php';
include HOMEDIR . '/inc/tpl/footer.tpl.php';

//тестирование - логи базы данных
/*$pieces = explode("Fri", $f3->get('db.instance')->log());
foreach ($pieces as $piece)
    echo $piece . '<br/>';
*/
