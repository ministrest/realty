<?php
/** @var \NMG\Page\Page $page */

$page = $f3->get('pageHelper');

$page->js[] = '/inc/jscss/contact.js';
$page->pageTitle = "Продажа недвижимости в Саратове ";
$module = 'sell';
setcookie("goodman[module]", $module, time() + 60 * 60 * 24 * 30);

$page->printHead();

include HOMEDIR . '/inc/tpl/header.tpl.php';
include HOMEDIR . '/inc/tpl/navigation.tpl.php';

if ($params['action'] == 'index' or !isset($params['action'])) {
    include __DIR__ . '/index.tpl.php';
}

include HOMEDIR . '/inc/tpl/sider_right.tpl.php';
include HOMEDIR . '/inc/tpl/footer.tpl.php';
