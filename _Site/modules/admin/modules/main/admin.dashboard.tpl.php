<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Главная панель
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Главная панель</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">

        <?php
        if($users->checkAccess('address',$f3)){ ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="inner" onClick="window.location.href='/admin/address/list'">
                        <h3><?php
                            $addresses = new \goodman\models\Address();
                            echo $addresses->count(); ?></h3>
                        <p>Адресов</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-location"></i>
                    </div>
                    <a href="/admin/address/list" class="small-box-footer">подробнее <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php } ?>
        <?php
        if($users->checkAccess('objects',$f3)){ ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner" onClick="window.location.href='/admin/objects/list'">
                        <h3><?php
                            $objects = new \goodman\models\Object_info();
                            echo $objects->count(); ?></h3>
                        <p>Объектов</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-home"></i>
                    </div>
                    <a href="/admin/objects/list" class="small-box-footer">подробнее <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php } ?>
        <?php
        if($users->checkAccess('adverts',$f3)){ ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner"  onClick="window.location.href='/admin/adverts/list'">
                        <h3><?php
                            $adverts = new \goodman\models\Advert_info();
                            echo $adverts->count(); ?></h3>
                        <p>Объявлений</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-book"></i>
                    </div>
                    <a href="/admin/adverts/list" class="small-box-footer">подробнее <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php } ?>
        <?php
        if($users->checkAccess('statistics',$f3)){ ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner"  onClick="window.location.href='/admin/'">
                        <h3><?php
                            //$adverts = new \goodman\models\Advert_info();
                            //echo $adverts->count(); ?>
                        </h3>
                        <p>Статистика</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-book"></i>
                    </div>
                    <a href="#" class="small-box-footer">подробнее <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php } ?>
        <?php
        $agents= new \goodman\models\Sales_agent_info();
        if($users->checkAccess('agents',$f3)){ ?>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner"  onClick="window.location.href='/admin/agents/contacts'">
                        <h3><?php echo $agents->count(); ?></h3>
                        <p>Агентов</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="/admin/agents/contacts" class="small-box-footer">подробнее <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>