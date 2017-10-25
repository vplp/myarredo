<?php

use yii\helpers\{
    Html, Url
};

$session = Yii::$app->session;
$this->context->title .=' в ' . $session['city']['lang']['title_where'];

?>

<main>
    <div class="page concact-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', $this->context->title); ?>
                <div class="of-conts">
                    <div class="one-cont">
                        <h4>Студия "СТАРЫЙ РИМ"</h4>
                        <div class="adres">
                            Малый Харитоньевский переулок, 7с1
                        </div>
                        <a href="tel:74997058998">+7 (499) 705-89-98</a>
                    </div>
                    <div class="one-cont">
                        <h4>Студия "СТАРЫЙ РИМ"</h4>
                        <div class="adres">
                            Малый Харитоньевский переулок, 7с1
                        </div>
                        <a href="tel:74997058998">+7 (499) 705-89-98</a>
                    </div>
                    <div class="one-cont">
                        <h4>Студия "СТАРЫЙ РИМ"</h4>
                        <div class="adres">
                            Малый Харитоньевский переулок, 7с1
                        </div>
                        <a href="tel:74997058998">+7 (499) 705-89-98</a>
                    </div>
                    <div class="one-cont">
                        <h4>Студия "СТАРЫЙ РИМ"</h4>
                        <div class="adres">
                            Малый Харитоньевский переулок, 7с1
                        </div>
                        <a href="tel:74997058998">+7 (499) 705-89-98</a>
                    </div>
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
        zoom: 5,
        center: new google.maps.LatLng(55.742130, 37.613583),
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
            position: marker.position,
            map: map,
            content: template
        });

        marker.addListener('click', function() {
            map.setCenter(new google.maps.LatLng(
                this.position.lat(),
                this.position.lng() ) );

            infoBubble.setContent(marker.content);
            infoBubble.open(map, marker);
        });
        return marker;
    }

    var markers = [
        {
            position: new google.maps.LatLng(55.670998, 37.518773),//Удальцова 1-А
            city: "Москва",
            address: "улица Удальцова, 1А",
            phone: "+7 (495) 150-21-21",
            country: "Россия"
        },
        {
            position: new google.maps.LatLng(55.758028, 37.553448),//Шмитовский проезд, 7/4
            city: "Москва",
            address: "Шмитовский проезд, 7/4",
            phone: "+7 (967) 153-33-47",
            country: "Россия"
        },
        {
            position: new google.maps.LatLng(55.756710, 37.562377), //ул.Родчельская, д.15, стр.8
            city: "Москва",
            address: "ул.Родчельская, д.15, стр.8",
            phone: "+7 (495) 120-35-00",
            country: "Россия"
        },
        {
            position: new google.maps.LatLng(55.765870, 37.645350), //Малый Харитоньевский переулок, 7с1
            city: "Москва",
            address: "Малый Харитоньевский переулок, 7с1",
            phone: "+7 (499) 705-89-98",
            country: "Россия"
        },
    ];

    var markings = markers.map(function(item) {
        return addMarker(item);
    });

    map.setZoom(11);
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