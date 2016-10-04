<?php
/** @var \NMG\Page\Page $page */

$page = $f3->get('pageHelper');
$page->js[] = '/inc/jscss/contact.js';

if (isset($_COOKIE['goodman']['module'])) {
    $module = $_COOKIE['goodman']['module'];
} else {
    $module = 'buy';
}
$page->pageTitle = "Купить и продать недвижимость в Саратове - о компании ";
$page->printHead();

include HOMEDIR . '/inc/tpl/header.tpl.php';
include HOMEDIR . '/inc/tpl/navigation.tpl.php';

include __DIR__ . '/index.tpl.php';

include HOMEDIR . '/inc/tpl/sider_right.tpl.php';
include HOMEDIR . '/inc/tpl/footer.tpl.php';
