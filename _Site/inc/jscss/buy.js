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