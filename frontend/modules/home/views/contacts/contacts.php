<?php

use yii\helpers\{
    Html, Url
};

$session = Yii::$app->session;
$this->context->title .= ' в ' . $session['city']['lang']['title_where'];


?>

    <main>
        <div class="page concact-page">
            <div class="container large-container">
                <div class="col-md-12">
                    <?= Html::tag('h1', $this->context->title); ?>
                    <div class="of-conts">

                        <?php foreach ($partners as $partner): ?>
                            <div class="one-cont">
                                <?= Html::tag('h4', $partner->profile->name_company); ?>
                                <div class="adres">
                                    <?= $partner->profile->address ?>
                                </div>
                                <a href="tel:<?= $partner->profile->phone ?>"><?= $partner->profile->phone ?></a>
                            </div>
                        <?php endforeach; ?>


                    </div>
                    <div class="warning">
                        * Обращаем ваше внимание, цены партнеров сети могут отличаться.
                    </div>
                    <div class="map-cont">
                        <div id="map"></div>

                        <?= Html::a(
                            'Посмотреть все офисы продаж',
                            Url::toRoute('/home/contacts/list-partners'),
                            ['class' => 'view-all']
                        ); ?>

                    </div>
                </div>

            </div>
        </div>
    </main>

<?php
$template = '<div class="info-buble"><h4>${marker.city}</h4><div>${marker.address}</div><div>${marker.phone}</div><div class="country">${marker.country}</div></div>';

$script = <<<JS
initMap();

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: new google.maps.LatLng('$city->lat', '$city->lng'),
        mapTypeControl: true,
        scrollwheel: false,
        zoomControl: true,
        fullscreenControl: true,
        mapTypeId: 'roadmap'
    });

    var infoBubble = new InfoBubble({
        map: map,
        borderRadius: 0,
        maxWidth: 200,
        maxHeight: 200,
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


    function addMarker(marker) {
        var template = '$template';

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(marker.lat, marker.lng),
            map: map,
            content: template
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

    map.setZoom(10);
}
JS;

$this->registerJs($script, yii\web\View::POS_READY);

$this->registerJsFile(
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyDI-EyYe0E1ZPA9IpCTUbP2137VDAcHJGY',
    [
        'position' => yii\web\View::POS_END,
    ]
);
?>