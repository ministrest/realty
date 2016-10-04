<?php
/** @var \NMG\Page\Page $page */

$module = 'statistic';
$pageTitle = 'Администрирование. Статистика';
include HOMEDIR . '/modules/admins/modules/main/admin.top.tpl.php';
if (isset($params['controller']) & isset($params['action'])) {
    include __DIR__ . '/' . $params['action'] . '.php';
}
include HOMEDIR . '/modules/admin/modules/main/admin.bottom.tpl.php';