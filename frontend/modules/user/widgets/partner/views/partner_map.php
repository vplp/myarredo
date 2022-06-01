<?php

use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);

?>
<div id="map"></div>

<?php
$template = '`<div class="info-buble"><h4>${marker.city}</h4><div>${marker.address}</div><div>${marker.phone}</div><div class="country">${marker.country}</div></div>`';

$script = <<<JS
var styleArray = [
                    {
                        "featureType": "administrative",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": "-100"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.province",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 65
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": "50"
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": "-100"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "all",
                        "stylers": [
                            {
                                "lightness": "30"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "all",
                        "stylers": [
                            {
                                "lightness": "40"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "hue": "#ffff00"
                            },
                            {
                                "lightness": -25
                            },
                            {
                                "saturation": -97
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "lightness": -25
                            },
                            {
                                "saturation": -100
                            }
                        ]
                    }
                ];

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
                this.position.lat() + 0.1,
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
