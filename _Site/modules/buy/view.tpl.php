<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<div class="content__main">
    <h1 class="headline headline_main">Хорошие сделки для хороших людей</h1>
    <div class="search-view">
        <div class="search-view__nav">
            <a href="/buy/search" class="button button_gray">Назад к списку</a>
            <a href="/buy" class="button button_gray">Новый поиск</a>
        </div>
        <div class="search-view__header">
            <h3 class="search-header"><?= ($advert->id_category == '2' and $advert->getRooms() > 0) ? $advert->getRooms() .
                    '-комнатная квартира ' : mb_strtoupper(mb_substr($advert->getCategoryObject(), 0, 1)) . mb_substr($advert->getCategoryObject(), 1) . ' '; ?></h3>
        </div>
        <div class="search-view__photos fotorama" data-width="100%" data-ratio="16/9" data-max-width="100%"
             data-allowfullscreen="true"
             data-nav="thumbs">
            <?php
            $obj_images = $object->getImages();
            if (isset($obj_images) and !empty($obj_images)) {
                $all = count($obj_images);
                foreach ($obj_images as $key => $image): ?>
                    <a href="<?= $image->catalog . '/' . $image->filename ?>"
                       data-caption="<?= ($key + 1) . ' из ' . $all ?>"><img
                            src="<?= $image->catalog . '/thumbs/' . $image->filename ?>"
                            data-thumb="<?= $image->catalog . '/thumbs/' . $image->filename ?>"></a>
                <?php endforeach;
            } else ?>
        </div>

        <div class="search-view__flat-info">
            <h3 class="search-header">
                <?php
                $address = $object->getAddressModel();

                echo $address->getAddress();
                ?></h3>
            <p><span
                    class="flat-description__column_header flat-description_price"><?= number_format($advert->value, 0, ',', ' '); ?>
                    руб.</span></p>
            <p><?= number_format(($advert->value / $object->full_space), 0, ',', ' '); ?>руб. за м<sup>2</sup></p>
            <div class="flat-info">
                <?php if (isset($object->floor) and ($object->floor > 0)) { ?>
                    <div class="flat-info__row">
                        <span
                            class="row__title">Этаж:</span> <?= $object->floor . ((isset($building) and ($building->floors_total > 0)) ? '/' . $building->floors_total : '') ?>
                    </div>
                <?php }
                if (isset($building) and (!empty($building->getBuildingType()))) { ?>
                    <div class="flat-info__row">
                            <span
                                class="row__title">Тип дома:</span> <?= $building->getBuildingType(); ?>
                    </div>
                <?php }
                if (isset($object->full_space) and ($object->full_space > 0)) {
                    ?>
                    <div class="flat-info__row">
                        <span class="row__title">Общая площадь:</span> <?= $object->full_space ?> м<sup>2</sup>
                    </div>
                <?php }
                if (isset($object->kitchen_space) and ($object->kitchen_space > 0)) {
                    ?>
                    <div class="flat-info__row">
                        <span class="row__title">Площадь кухни:</span> <?= $object->kitchen_space; ?> м<sup>2</sup>
                    </div>
                <?php }
                if (isset($object->living_space) and ($object->living_space > 0)) {
                    ?>
                    <div class="flat-info__row">
                        <span class="row__title">Жилая площадь:</span> <?= $object->living_space; ?> м<sup>2</sup>
                    </div>
                <?php }
                if (isset($advert->id_deal_status) and ($advert->id_deal_status > 0)) {
                    ?>
                    <div class="flat-info__row">
                    <span class="row__title">Cтатус сделки:</span> <?= $advert->getStatus(); ?>
                    </div><?php }
                if (isset($advert->mortgage) and ($advert->mortgage == 1)) {
                    ?>
                    <div class="flat-info__row">
                        <span class="row__title">Ипотека: </span> да
                    </div><?php }
                if (isset($advert->haggle) and ($advert->haggle == 1)) {
                    ?>
                    <div class="flat-info__row">
                        <span class="row__title">Торг: </span> да
                    </div><?php }
                if (isset($advert->rent_pledge) and ($advert->rent_pledge == 1)) {
                    ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Залог: </span> да
                    </div><?php }
                if (isset($advert->not_for_agents) and ($advert->not_for_agents == 1)) {
                    ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Не для агентов:</span> да
                    </div><?php }
                if (isset($advert->id_property_type) and ($advert->id_property_type>0)) {
                    ?>
                    <div class="flat-info__row">
                    <span class="row__title">Тип собственности:</span> <?= $advert->getPropertyType(); ?>
                    </div><?php }
                if (isset($object->id_renovation) and ($object->id_renovation > 0)) {
                    ?>
                    <div class="flat-info__row">
                    <span class="row__title">Состояние ремонта: </span> <?= $object->getRenovation(); ?>
                    </div><?php }
                if (isset($object->id_quality) and ($object->id_quality > 0)) {
                    ?>
                    <div class="flat-info__row">
                    <span class="row__title">Состояние объекта: </span> <?= $object->getQuality(); ?>
                    </div><?php }
                if (isset($object->id_lot_type) and !empty($object->id_lot_type)) {
                    ?>
                    <div class="flat-info__row">
                    <span class="row__title">Тип участка: </span> <?= $object->getLot(); ?>
                    </div><?php }
                if (isset($object->lot_area) and !empty($object->lot_area)) { ?>
                    <div class="flat-info__row">
                    <span class="row__title">Площадь участка: </span> <?= $object->lot_area; ?>
                    </div><?php }
                if (isset($object->id_category_agent) and ($object->id_category_agent > 0)) { ?>
                    <div class="flat-info__row">
                    <span class="row__title">Категория агента: </span> <?= $object->getCategoryAgent(); ?>
                    </div><?php }
                if (isset($object->new_flat) and ($object->new_flat == 1)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Новостройка: </span> да
                    </div><?php }
                if (isset($object->rooms) and ($object->rooms > 0)) { ?>
                    <div class="flat-info__row">
                    <span class="row__title">Количество комнат: </span> <?= $object->rooms; ?>
                    <?= isset($object->rooms_type) ? ' ' . $object->rooms_type : ''; ?>
                    </div><?php }
                if (isset($object->rooms_offered) and ($object->rooms_offered > 0)) { ?>
                    <div class="flat-info__row">
                    <span class="row__title">Комнат в сделке: </span> <?= $object->rooms_offered; ?>
                    </div><?php }
                if (isset($object->id_floor_covering) and ($object->id_floor_covering > 0)) { ?>
                    <div class="flat-info__row">
                    <span class="row__title">Покрытие пола: </span> <?= $object->getFloorCovering(); ?>
                    </div><?php }
                if (isset($object->open_plan) and ($object->open_plan == 1)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Открытая планировка: </span> да
                    </div><?php }
                if (isset($object->apartments) and ($object->apartments == 1)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Апартаменты: </span> да
                    </div><?php }
                if (isset($object->furniture) and ($object->furniture == 1)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Мебель: </span> да
                    </div><?php }
                if (isset($object->bathroom_unit) and !empty($object->bathroom_unit)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Санузел: </span> <?= isset($object->toilet) ? (($object->toilet == 1) ? 'туалет ' : '') : '' ?>
                    <?= isset($object->shower) ? (($object->shower == 1) ? ' душ ' : '') : '' ?>
                    <?= isset($object->bathroom_unit) ? ' ' . $object->bathroom_unit : '' ?>
                    </div><?php }
                if (isset($object->balcony) and ($object->balcony == 1)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Балкон: </span> да
                    </div><?php }
                if (isset($object->elevator) and ($object->elevator == 1)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Лифт: да
                    </div><?php }
                if (isset($object->phone) and ($object->phone == 1)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Телефон: </span> да
                    </div><?php }
                if (isset($object->internet) and ($object->internet == 1)) { ?>
                    <div class="flat-info__row">
                    <span
                        class="row__title">Интернет: </span> да
                    </div><?php }
                if (isset($object->window_view) and !empty($object->window_view)) { ?>
                    <div class="flat-info__row">
                            <span
                                class="row__title">Вид из окна: </span> <?= $object->window_view ?>
                    </div>
                <?php }
                $houses = array(3, 4, 5, 6, 7, 8);
                if (in_array($advert->id_category, $houses)) {
                    if (isset($object->kitchen) and ($object->kitchen == 1)) {
                        ?>
                        <div class="flat-info__row">
                        <span
                            class="row__title">Кухня: </span> да
                        </div><?php }
                    if (isset($object->pool) and ($object->pool == 1)) { ?>
                        <div class="flat-info__row">
                        <span
                            class="row__title">Бассейн: </span> да
                        </div><?php }
                    if (isset($object->sauna) and ($object->sauna == 1)) { ?>
                        <div class="flat-info__row">
                        <span
                            class="row__title">Сауна: </span> да
                        </div><?php }
                    if (isset($object->heating_supply) and ($object->heating_supply == 1)) { ?>
                        <div class="flat-info__row">
                        <span
                            class="row__title">Отопление: </span> да
                        </div><?php }
                    if (isset($object->water_supply) and ($object->water_supply == 1)) { ?>
                        <div class="flat-info__row">
                        <span
                            class="row__title">Водоснабжение: </span> да
                        </div><?php }
                    if (isset($object->gas_supply) and ($object->gas_supply == 1)) { ?>
                        <div class="flat-info__row">
                        <span
                            class="row__title">Газоснабжение: </span> да
                        </div><?php }
                    if (isset($object->electricity_supply) and ($object->electricity_supply == 1)) { ?>
                        <div class="flat-info__row">
                        <span
                            class="row__title">Электричество: </span> да
                        </div><?php }
                    if (isset($object->sewerage_supply) and ($object->sewerage_supply == 1)) { ?>
                        <div class="flat-info__row">
                            <span
                                class="row__title">Канализация: </span> да
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
        <div class="search-view__text">
            <?= (isset($object->description)) ? $object->description : ''; ?>
        </div>
        <?php if (isset($advert->user_id)) {
            $agent = $advert->getAgent();
            if (isset($agent)) {
                ?>
                <div class="search-view__agent">
                    <div class="agent__photo">
                        <?php $avatar = $agent->getAvatar(); ?>
                        <img src="<?= $avatar ?>" class="agent__photo__image" alt="User Image">
                    </div>
                    <div class="agent__description">
                        <p><?= $agent->name; ?>, специалист по объекту</p>
                        <h3 class="search-header"><?= $agent->formatPhone($agent->phone); ?></h3>
                        <?php if(isset($agent->additional_number)):?>
                    <h4 class="search-header"><?= $agent->formatPhone($agent->additional_number); ?></h4>
                    <?php endif; ?>
                        <p>Звоните, отвечу на все вопросы!</p>
                    </div>
                </div>
            <?php }
        } ?>
        <div class="search-view__map">
            <div class="flat-location" title="<?= $address->getAddress() ?>"
                 id="<?= $object->id_object ?>">
            </div>
        </div>
        <div class="search-view__text">
            Поделиться в:
            <script type="text/javascript">(function () {
                    if (window.pluso)if (typeof window.pluso.start == "function") return;
                    if (window.ifpluso == undefined) {
                        window.ifpluso = 1;
                        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                        s.type = 'text/javascript';
                        s.charset = 'UTF-8';
                        s.async = true;
                        //s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
                        s.src = '/inc/jscss/pluso-like.js';
                        var h = d[g]('body')[0];
                        h.appendChild(s);
                    }
                })();</script>
            <div class="pluso" data-background="transparent"
                 data-options="medium,square,line,horizontal,nocounter,theme=06"
                 data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        ymaps.ready(init);
        var myMap;
        var dataArray = document.getElementsByClassName('flat-location');

        function init() {
            $.each(dataArray, function (index) {
                var myGeocoder = ymaps.geocode(dataArray[index].title);
                myGeocoder.then(
                    function (res) {
                        var coords = res.geoObjects.get(0).geometry.getCoordinates();
                        var myGeocoder = ymaps.geocode(coords, {kind: 'street'});
                        myGeocoder.then(
                            function (res) {
                                var street = res.geoObjects.get(0);
                                var name = street.properties.get('name');

                                myMap = new ymaps.Map(dataArray[index], {
                                    center: coords,
                                    zoom: 15
                                });
                                myPlacemark = new ymaps.Placemark(coords, {
                                    hintContent: name,
                                    balloonContent: dataArray[index].title
                                });

                                myMap.geoObjects.add(myPlacemark);
                            }
                        );
                    });

            });
        }
    });
</script>