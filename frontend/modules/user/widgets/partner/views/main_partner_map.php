<?php

use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);

?>
<div id="map"></div>
<?php 
    // формируем массив меток для карты главного партнера
    // если данные с JSON не пустые
    if (!empty($dataJS)) {
        $arr_map_data = json_decode($dataJS);
        // если после преобразования массив не пустой
        if (!empty($arr_map_data)) {
            foreach($arr_map_data as $oneitem) {
                // добавляем метки в наш массив
                $arr_location[] = array(
                    'lat' => $oneitem->lat,
                    'lng' => $oneitem->lng
                );
            }

            $arr_location = json_encode($arr_location);
        }
        // иначе присваиваем 0
        else {
            $arr_location = 0;
        }
    }
    // иначе присваиваем 0
    else {
        $arr_location = 0;
    }
?>
<?php
$template = '`<div class="info-buble"><h4>${marker.city}</h4><div>${marker.address}</div><div>${marker.phone}</div><div class="country">${marker.country}</div></div>`';

$script = <<<JS
// массив для стилей пользовательской карты
var styleArray = [
            
                ];

// если массив с метками существует то присваиваем его иначе записываем как false
var arrMapsData = $arr_location || false;

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: $zoom,
        center: new google.maps.LatLng('$lat', '$lng'),
        mapTypeControl: true,
        scrollwheel: false,
        zoomControl: true,
        fullscreenControl: true,
        mapTypeId: 'roadmap',
        styles: styleArray
    });

    var infoBubble = new InfoBubble({
        map: map,
        borderRadius: 0,
        maxWidth: 200,
        maxHeight: 170,
        minHeight: 170,
        minWidth: 200,
        shadowStyle: 0,
        arrowSize: 0,
        borderWidth: 2,
        borderColor: '#E3E0D5',
        disableAutoPan: true,
        hideCloseButton: false,
        arrowPosition: 55,
        padding: 0
    });

    // если массив с метками существует, и если в этом массиве более 1 елемент
    if (arrMapsData && arrMapsData.length > 1) {
        // запускаем функционал отцентровки карты с несколькими метками
        var latlngbounds = new google.maps.LatLngBounds();
        for ( var i=0; i<arrMapsData.length; i++ ){
            latlngbounds.extend(arrMapsData[i]);
        }
        map.setCenter(latlngbounds.getCenter(), map.fitBounds(latlngbounds));
    }

    function addMarker(marker) {
        var template = $template;

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(marker.lat, marker.lng),
            map: map,
            content: template,
            icon: '$bundle->baseUrl' + marker.image
        });

        marker.addListener('click', function() {
            map.setCenter(new google.maps.LatLng(
                this.position.lat(),
                this.position.lng() 
            ));

            infoBubble.setContent(marker.content);
            infoBubble.open(map, marker);
        });
        
        return marker;
    }

    var markers = $dataJS;

    var markings = markers.map(function(item) {
        return addMarker(item);
    });
}
// Вызов функции инициализации карты с некоторым выжиданием, для избежания ошибок - google is not defined
(function() {
    setTimeout(function() {
        initMap();
    }, 1000);
})();
JS;

$this->registerJs($script);

$this->registerJsFile(
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyBpBQH_7WVv01t7JD9zGQ_g-gN8VT5hsKA&language=' . substr(Yii::$app->language, 0, 2),
    [
        'position' => yii\web\View::POS_END,
        'async' => true,
        'defer' => true,
    ]
);
