<?php
/**
 * @author Andrey A. Nechaev <nechaev@nmgcom.ru>
 * @copyright Copyright (c) 2015 Nechaev Marketing Group (http://www.nmgcom.ru)
 */
use NMG\Page\Page;
define('ROOTDIR', __DIR__);

include_once(ROOTDIR.'/classes/bootstrap.php');

$f3 = require_once HOMEDIR . '/classes/f3/lib/base.php';

// Load configuration
$f3->config('config.ini');

$f3->set('pageHelper', new Page($f3));
/*$f3->set('ONERROR',function($f3){
    include_once(ROOTDIR.'/modules/error.php');
});*/
// Connect to database
$f3->set("db.instance", new DB\SQL(
    "mysql:host=" . $f3->get("db.host") . ";port=" . $f3->get("db.port") . ";dbname=" . $f3->get("db.name"),
    $f3->get("db.user"),
    $f3->get("db.pass")
));

$f3->route('GET|HEAD|POST /@controller',
    function($f3, $params) {
        $path = ROOTDIR . '/modules/' . $params['controller'] . '/index.php';
        if (file_exists($path)) {
            include_once($path);
        }
        else $f3->error(404);
    }
);
$f3->route('GET|HEAD|POST /@controller/@action',
    function($f3, $params) {
        $path = ROOTDIR.'/modules/'.$params['controller'].'/'.$params['action'].'.php';
        if ( ! file_exists($path)) {
            $path = ROOTDIR.'/modules/'.$params['controller'].'/index.php';
        }

        if (file_exists($path)) {
            include_once($path);
        } else {
            $f3->error(404);
        }
    }
);
$f3->route('GET|HEAD|POST /@controller/@action/@param',
    function($f3, $params) {
        $path = ROOTDIR.'/modules/'.$params['controller'].'/'.$params['action'].'.php';
        if ( ! file_exists($path)) {
            $path = ROOTDIR.'/modules/'.$params['controller'].'/index.php';
        }

        if (file_exists($path)) {
            include_once($path);
        } else {
            $f3->error(404);
        }
    }
);
$f3->route('GET|HEAD|POST /',
    function($f3) {
        include_once(ROOTDIR.'/modules/buy/index.php');
    }
);

$f3->route('GET|HEAD|POST /admin/images/@action/@param',
    function($f3,$params) {
        include_once(ROOTDIR.'/modules/admin/images/index.php');
    }
);
$f3->route('POST /admin',
    function($f3) {
        include_once(ROOTDIR.'/modules/admin/index.php');
    }
);
$f3->route('GET|HEAD|POST /admin/@controller/@action',
    function($f3,$params) {
        include_once(ROOTDIR.'/modules/admin/index.php');
    }
);
$f3->route('GET|HEAD|POST /admin/@controller/@action/@param',
    function($f3,$params) {
        include_once(ROOTDIR.'/modules/admin/index.php');
    }
);

$f3->run();

