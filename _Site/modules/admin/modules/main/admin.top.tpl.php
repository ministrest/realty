<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/admin.css">
    <!-- jQuery 2.1.4 -->
    <script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/jquery/jquery-1.11.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/bootstrap.min.css">
    <!-- FastClick -->
    <script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/fastclick/fastclick.min.js"></script>

    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datepicker/datepicker3.css">
    <script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script
        src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datepicker/locales/bootstrap-datepicker.ru.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/app.min.js"></script>
    <script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/js.cookie.js"></script>
    <!-- ToTop -->
    <script src="<?= $f3->get("homeurl") ?>/inc/jscss/totop.js"></script>
    <!-- autocomplete plugin -->
    <script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/jquery/jquery-ui-1.12/jquery-ui.js"></script>
    <link rel="stylesheet" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/jquery/jquery-ui-1.12/jquery-ui.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/image/imagestyle.css">
    <link rel="stylesheet" type="text/css" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/image/imagestyle.css">
    <link rel="stylesheet" type="text/css" href="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datatable/datatable.min.css">

</head>
<div id="toTop"></div>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= $f3->get("homeurl") ?>/admin" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>P</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Админ</b>Панель</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Навигция </span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown_citylist user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php
                            $user = $users->find(array('hash=? and id_user=?', $_COOKIE['goodman']['hash'], (int)$_COOKIE['goodman']['id']));
                            $user = $user[0];
                            if (isset($user)) $avatar = $user['avatar'];
                            else $avatar = $users->avatar;

                            if (empty($avatar)) {
                                $path = $f3->get("homeurl") . '/inc/i/user.jpg';
                            } else {
                                $path = $f3->get("homeurl") . '/inc/i/avatar/' . $avatar;
                            }
                            ?>
                            <img src="<?= $path ?>" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?php
                                $user_group = (isset($user)) ? $user['id_group'] : $users->id_group;
                                
                                echo (isset($user)) ? $user['login'] : $users->login; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= $path ?>" class="img-circle" alt="User Image">
                                <p>
                                    <?= (isset($user)) ? $user['login'] : $users->login ?> -
                                    <?= (isset($user)) ? $user['email'] : $users->email ?>
                                    <small>
                                        Зарегистрирован <?= date('m/Y', strtotime((isset($user)) ? $user['created'] : $users->created)) ?></small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">

                                </div>
                                <div class="pull-right">
                                    <a href="<?= $f3->get("homeurl") ?>/admin/logout" class="btn btn-default btn-flat">Выход</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">НАВИГАЦИЯ</li>
                <li class="">
                    <a href="<?= $f3->get("homeurl") ?>/admin">
                        <i class="fa fa-dashboard"></i> <span>Главная панель</span>
                    </a>
                </li>
                <?php
                if(isset($_COOKIE['treeview'])) {
                    $treeview = $_COOKIE['treeview'];
                } else {
                    $treeview = array("adverts"=> 0,"users"=>0, "objects"=>1, "address"=> 0);
                }
                if($users->checkAccess('users',$f3)){ ?>
                <li id="users" class="treeview <?=($params['controller']=='users' or $treeview['users']==1)?'active':''?>">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>Пользователи</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href="<?= $f3->get("homeurl") ?>/admin/users/list"><i class="fa fa-circle-o"></i> Список пользователей</a>
                        </li>
                        <li class="">
                            <a href="<?= $f3->get("homeurl") ?>/admin/users/add"><i class="fa fa-circle-o"></i> Добавить пользователя</a>
                        </li>
                        <li class="">
                            <a href="<?= $f3->get("homeurl") ?>/admin/agents/listagent"><i class="fa fa-circle-o"></i> Список агентов</a>
                        </li>
                    </ul>
                </li>
                <?php }
                if($users->checkAccess('agents',$f3)){ ?>
                <li id="agents" class="treeview <?=($params['controller']=='agents' or $treeview['agents']==1)?'active':''?>">
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span>Агенты</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href="<?= $f3->get("homeurl") ?>/admin/agents/contacts"><i class="fa fa-circle-o"></i> Контакты агентов</a>
                        </li>
                        <li class="">
                            <?php
                            if (isset($user)) $agent = $user->getAgent();
                            else $agent = $users->getAgent();

                            if(isset($agent->id_sales_agent) and $agent->id_sales_agent>0){
                            ?>
                            <a href="<?= $f3->get("homeurl") ?>/admin/agents/editagent/<?=$agent->id_sales_agent?>"><i class="fa fa-circle-o"></i> Персональные данные</a>
                        <?php } else {?>
                            <a href="<?= $f3->get("homeurl") ?>/admin/agents/addagent?user=<?= (isset($user)) ? $user->id_user : $users->id_user ?>"><i class="fa fa-circle-o"></i> Персональные данные</a>
                        <?php } ?>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if($users->checkAccess('statistic',$f3)){ ?>
                    <!--
                <li class="treeview <?=($params['controller']=='statistic')?'active':''?>">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Статистика</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href="<?= $f3->get("homeurl") ?>/admin/statistic/list"><i class="fa fa-circle-o"></i> Список</a>
                        </li>
                        <li class="">
                            <a href="<?= $f3->get("homeurl") ?>/admin/statistic/add"><i class="fa fa-circle-o"></i> Добавить</a>
                        </li>
                    </ul>
                </li>
                -->
                <?php } ?>
                <?php if($users->checkAccess('address',$f3)){ ?>
                    <li id="address" class="treeview  <?=($params['controller']=='address' or $treeview['address']==1)?'active':''?>">
                        <a href="#">
                            <i class="fa fa-globe"></i>
                            <span>Адреса</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="">
                                <a href="<?= $f3->get("homeurl") ?>/admin/address/list"><i class="fa fa-circle-o"></i> Все адреса</a>
                            </li>
                            <li class="">
                                <a href="<?= $f3->get("homeurl") ?>/admin/address/add"><i class="fa fa-circle-o"></i> Добавить адрес</a>
                            </li>
                            <?php if($users->checkAccess('foradmin',$f3)){ ?>
                            <li class="">
                                <a href="<?= $f3->get("homeurl") ?>/admin/address/listregions"><i class="fa fa-circle-o"></i> Регионы</a>
                            </li>
                            <li class="">
                                <a href="<?= $f3->get("homeurl") ?>/admin/address/listlocalities"><i class="fa fa-circle-o"></i> Насел.пункты</a>
                            </li>
                            <li class="">
                                <a href="<?= $f3->get("homeurl") ?>/admin/address/listsublocalities"><i class="fa fa-circle-o"></i> Районы</a>
                            </li>
                                <li class="">
                                    <a href="<?= $f3->get("homeurl") ?>/admin/address/listdistricts"><i class="fa fa-circle-o"></i> Муниц.районы</a>
                                </li>
                                <li class="">
                                    <a href="<?= $f3->get("homeurl") ?>/admin/address/liststreets"><i class="fa fa-circle-o"></i> Улицы</a>
                                </li>
                            <?php } ?>
                            <li class="">
                                <a href="<?= $f3->get("homeurl") ?>/admin/buildings/list"><i class="fa fa-circle-o"></i> Здания</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if($users->checkAccess('objects',$f3)){ ?>
                <li id="objects" class="treeview <?=($params['controller']=='objects' or  $treeview['objects']==1)?'active':''?>">
                    <a href="#">
                        <i class="fa fa-home"></i>
                        <span>Объекты</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="">
                            <a href="<?= $f3->get("homeurl") ?>/admin/objects/list"><i class="fa fa-circle-o"></i> Все объекты</a>
                        </li>
                        <li class="">
                            <a href="<?= $f3->get("homeurl") ?>/admin/objects/add"><i class="fa fa-circle-o"></i> Добавить объект</a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if($users->checkAccess('adverts',$f3)){ ?>
                    <li id="adverts" class="treeview <?=($params['controller']=='adverts' or $treeview['adverts']==1)?'active':''?>">
                        <a href="#">
                            <i class="fa fa-list-alt"></i>
                            <span>Объявления</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="">
                                <a href="<?= $f3->get("homeurl") ?>/admin/adverts/list"><i class="fa fa-circle-o"></i> Все объявления</a>
                            </li>
                            <li class="">
                                <a href="<?= $f3->get("homeurl") ?>/admin/adverts/add"><i class="fa fa-circle-o"></i> Добавить объявление</a>
                            </li>
                            <?php if ($user_group==2): ?>
                                <li class="">
                                    <a href="<?= $f3->get("homeurl") ?>/admin/adverts/addall"><i class="fa fa-circle-o"></i> Тестовая форма</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">