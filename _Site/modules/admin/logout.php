<?php
/** @var \NMG\Page\Page $page */

setcookie("goodman[id]", "", time() - 3600 * 24 * 30 * 12, "/");
setcookie("goodman[hash]", "", time() - 3600 * 24 * 30 * 12, "/");
$_SESSION = array(); //Очищаем сессию

$f3->reroute('/admin');