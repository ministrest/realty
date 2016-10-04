<?php
/** @var \NMG\Page\Page $page */
use goodman\helpers\Calculation;

$page = $f3->get('pageHelper');
$page->js[] = '/inc/jscss/contact.js';

if (isset($_COOKIE['goodman']['module'])) {
    $module = $_COOKIE['goodman']['module'];
} else {
    $module = 'buy';
}


$page->pageTitle = "Купить и продать недвижимость в Саратове - ипотечный калькулятор ";
$page->printHead();

include HOMEDIR . '/inc/tpl/header.tpl.php';
include HOMEDIR . '/inc/tpl/navigation.tpl.php';
if(isset($_POST['calculator'])) {
    /*
    t- количество периодов оплаты;
    kр — сумма кредита;
    k — процентная ставка, начисляемая на задолженность за период;
    ap - размер платежа за i — й период (i принимает значения от 1 до t);
    */
    // создаем хелпер 
    $helper = new Calculation($f3, 'calculator');
    $calculator = $helper->checkPost($_POST['calculator']);
    $errors = $helper->getErrors();

    if(empty($errors)) {
        $t = $calculator["period"] * 12;
        $sum = $calculator["price"];
        $k = $calculator["procent"] / 100 / 12;
        $if = $calculator["initial_fee"];
        $kp = $sum - $if;
        $ap = $kp * ($k + ($k / (pow((1 + $k), $t) - 1)));
    }
} 

    include __DIR__ . '/index.tpl.php';

include HOMEDIR . '/inc/tpl/sider_right.tpl.php';
include HOMEDIR . '/inc/tpl/footer.tpl.php';
