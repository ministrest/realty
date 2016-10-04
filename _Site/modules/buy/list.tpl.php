<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<div class="content__main">
    <?php include __DIR__ . '/_form.php'; ?>
    <div class="search-result">
        <?php
        if (isset($result_search) and $result_search!=0) { ?>
            <h3 class="search-result__header">Недвижимость - <?= $subset['total'] ?></h3>
            <div class="search-result__filters">
                <?php if (isset($filters)) {
                    foreach ($filters as $filter) {
                        ?>
                        <a href="/buy/search<?= '?category='.$filter['id_category'] ?>"
                           class="button button_gray <?= ($filter['id_category'] == $_GET['category']) ? 'button_hovered' : '' ?>"
                          
                             >
                            <?= $filter['category'] . ' - ' . $filter['summ'] ?></a>
                    <?php }
                } ?>
            </div>

            <?php
            foreach ($result_search as $advert) {
                ?>
                <div class="search-result__item">
                    <div class="search-result__main">
                        <div class="flat-image">
                            <div class="fotorama" data-width="250" data-ratio="700/467" data-max-width="100%" data-nav="thumbs">
                                <?php $object = $advert->getObject();
                                $obj_images = $object->getImages();
                                if (isset($obj_images) and !empty($obj_images)) {
                                    $all = count($obj_images);
                                    foreach ($obj_images as $key=>$image): ?>
                                <a href="<?= $image->catalog . $image->filename ?>" data-caption="<?= ($key+1).' из '.$all?>"><img src="<?= $image->catalog . 'thumbs/' . $image->filename ?>"></a>
                                    <?php endforeach;
                                } else { ?>
                                    <img src="/inc/i/img-no-photo.jpg">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="flat-description">
                            <a class="link link_search" href="/buy/view/<?=$advert->id_advert?>"><h3 class="search-header"><?=($advert->id_category=='2' and $advert->getRooms()>0)? $advert->getRooms().'-комнатная квартира' : mb_strtoupper(mb_substr($advert->getCategoryObject(), 0, 1)) . mb_substr($advert->getCategoryObject(), 1) ?></h3></a>
                            <div class="flat-description__column column_main">
                                <p><span
                                        class="flat-description__column_header flat-description_price"><?= number_format($advert->value, 0, ',', ' '); ?>
                                        руб.</span></p>
                                <p>
                                    <?php
                                    $address = $object->getAddressModel();
                                    $building = $address->getBuilding();
                                    echo 'р-он ' . $address->getSublocality();
                                    ?></p>
                            </div>
                            <div class="flat-description__column">
                                <?php if (isset($object->full_space)) { ?>
                                    <p><span class="flat-description__column_header">
                                    <?= $object->full_space; ?>
                                            м<sup>2</sup></span></p>
                                    <p>
                                        кухня <?= $object->kitchen_space; ?> м<sup>2</sup></p>
                                    <p>
                                        жилая <?= $object->living_space; ?> м<sup>2</sup></p>
                                <?php } ?>
                            </div>
                            <div class="flat-description__column">
                                <?php if (isset($building)) { ?>
                                    <p><span
                                            class="flat-description__column_header"><?= $object->floor . ' этаж из ' . $building->floors_total; ?></span>
                                    </p>
                                    <p><?= $building->getBuildingType(); ?></p>
                                <?php } ?>
                                <p>
                                    <?= ($object->new_flat == '1') ? 'новостройка' : 'вторичка' ?></p>

                            </div>
                            <div class="flat-buttons">
                                <a class="button button_gray button_showmap">Показать на карте</a>
                                <a href="/buy/view/<?=$advert->id_advert?>" class="button button_form button_search">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    <div class="search-result__map">
                        <div class="flat-location" style="display: none;" title="<?= $address->getAddress() ?>"
                             id="<?= $object->id_object ?>">
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <div>
                <h2 class="headline">По вашему запросу ничего не найдено</h2>
                <p>Попробуйте ввести другие параметры и повторить поиск</p>
            </div>
        <?php } ?>

        <div class="pagination">
            <?php if(isset($pages)){?>
            <!--<a class="link link_pagination" href="/buy/search/<?=$pages->getFirst()?>">В начало</a> -->
            <a class="link link_pagination" href="/buy/search/<?=$pages->getPrev()?>">Назад</a>
            <?php for($i=1;$i<=$subset['count'];$i++) {
                (!isset($params['param']))? $params['param'] = 1 : '';
                ?>
                <a class="link<?= ($params['param']==$i)?' active':'' ?>" href="/buy/search/<?=$i?>"><?= $i ?></a>
            <?php } ?>
            <a class="link link_pagination" href="/buy/search/<?=$pages->getNext()?>">Вперед</a>
            <!--<a class="link link_pagination" href="/buy/search/<?=$pages->getLast()?>">В конец</a>-->
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('.button_showmap').click(function () {
            $(this).toggleClass('button_unshowmap');
            this.textContent = (this.textContent == 'Показать на карте') ? 'Скрыть карту' : 'Показать на карте';

            var dataAr = $(this).parent().parent().parent().parent().children('div.search-result__map').children('div.flat-location');
            $.each(dataAr, function (index) {
                dataAr[index].style.display = (dataAr[index].style.display == 'none') ? 'table-cell' : 'none';

            });
            return false;
        });
    });


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
</script>