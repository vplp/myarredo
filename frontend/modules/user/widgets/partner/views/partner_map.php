<div id="map"></div>

<?php
$template = '`<div class="info-buble"><h4>${marker.city}</h4><div>${marker.address}</div><div>${marker.phone}</div><div class="country">${marker.country}</div></div>`';

$script = <<<JS
initMap();

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: $zoom,
        center: new google.maps.LatLng('$lat', '$lng'),
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
            template = $template;

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