<div class="navigation">
    <div class="container">
        <div class="control-group">
            <a class="button button_section<?=($module=='buy')?' button_active':''?>" href="<?= $f3->get("homeurl") ?>">
                <span class="button__text">Купить <span class="button__description">недвижимость</span></span>
            </a><a class="button button_section<?=($module=='sell')?' button_active':''?>" href="<?= $f3->get("homeurl") ?>/sell">
                <span class="button__text">Продать <span class="button__description">недвижимость</span></span>
            </a>
        </div>
        <button class="button button_toggle button_size_l">
            <span class="icon icon_lines"></span>
            <span class="button__text">Меню</span>
        </button>

        <ul class="menu menu_h" style="">
            <li class="menu__item<?=($params['controller']=='about')?' menu__item_active':''?>"><a href="<?= $f3->get("homeurl") ?>/about" class="menu__link">О компании</a>
            </li><?php if($module=='buy'){ ?><li class="menu__item">
                <a href="#" class="menu__link">Услуги</a>
                <ul class="menu menu_sub">
                    <li class="menu__item"><a class="menu__link" href="<?= $f3->get("homeurl") ?>/calculator">Ипотечный калькулятор</a></li>
                    <?php /* ?>
                    <li class="menu__item"><a class="menu__link" href="#">Поиск по ипотечным кредитам</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Помощь брокера</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Помощь юриста</a></li>
                    <?php */ ?>
                </ul>
            </li><li class="menu__item"><a href="#" class="menu__link">Ипотека</a></li><?php } ?><?php/*
            if($module=='sell'){ ?><li class="menu__item">
                <a href="#" class="menu__link">Услуги</a>
                <ul class="menu menu_sub">
                    <li class="menu__item"><a class="menu__link" href="#">Оценка недвижимости онлайн</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Согласование перепланировок</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Перевод в жилой/не жилой фонд</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Помощь юриста</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Часто задаваемые вопросы</a></li>
                </ul>
            </li><?php } */?><li class="menu__item<?=($params['controller']=='contacts')?' menu__item_active':''?>"><a href="<?= $f3->get("homeurl") ?>/contacts" class="menu__link">Контакты</a></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="container">