<div class="content__main">

    <h1 class="headline headline_main">Хорошие сделки для хороших людей</h1>

    <div class="contacts">
        <h2 class="headline">Наши контакты</h2>

        <div class="contacts__column">
            <span class="label"> Адрес:</span>
            г. Саратов, Астраханская, 118в
        </div>
        <div class="contacts__column">
            <span class="label"> Телефон:</span>
            8 (8452) 255-033
        </div>
        <div class="contacts__map">
            <div class="location" title="г. Саратов, Астраханская, 118в">
            </div>
        </div>

        <?php include __DIR__ . '/_form.php'; ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        ymaps.ready(init);
        var myMap;
        var dataArray = document.getElementsByClassName('location');

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