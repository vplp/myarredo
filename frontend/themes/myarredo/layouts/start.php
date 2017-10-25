<?php

use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\catalog\widgets\category\CategoryOnMainPage;
use frontend\modules\catalog\widgets\factory\FactoryOnMainPage;
//use frontend\modules\catalog\widgets\sale\SaleOnMainPage;

$bundle = AppAsset::register($this);
?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<main>
    <div class="home-page">
        <div class="home-slidee-wrap">
            <div id="home-slider" class="carousel slide" data-ride="carousel">

                <div class="carousel-inner">
                    <div class="item active">
                        <img src="<?= $bundle->baseUrl ?>/img/pictures/thumb1.jpg" alt="Изображение слайда">
                    </div>
                    <div class="item">
                        <img src="<?= $bundle->baseUrl ?>/img/pictures/thumb2.png" alt="Изображение слайда">
                    </div>
                </div>

                <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

            </div>

            <div class="search-form flex c-align">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Название товара или фабрики">
                </div>
                <button type="button" class="btn btn-success">Найти</button>
            </div>

        </div>

        <?= CategoryOnMainPage::widget(); ?>

        <!-- Новинки -->

        <div class="novelties">
            <div class="container large-container">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="header">
                            <h2>Новинки</h2>
                            <a href="#" class="more">Смотреть все категории</a>
                            <div id="novelties-slider" class="carousel slide" data-ride="carousel">

                                <div class="carousel-inner">

                                    <div class="item active">
                                        <div class="item-in">
                                            <div class="left">
                                                <a href="#" class="large">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="right">
                                                <a href="#" class="smaller">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                </a>
                                                <a href="#" class="smaller">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                </a>
                                                <a href="#" class="smaller">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                </a>
                                                <a href="#" class="smaller">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="item">
                                        <div class="item-in">
                                            <div class="left">
                                                <a href="#" class="large">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="right">
                                                <a href="#" class="smaller">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                </a>
                                                <a href="#" class="smaller">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                </a>
                                                <a href="#" class="smaller">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                </a>
                                                <a href="#" class="smaller">
                                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="arr-cont">
                                    <a class="left left-arr" href="#novelties-slider" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <div class="indent"></div>
                                    <a class="right right-arr" href="#novelties-slider" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- конец Новинки -->

        <?php //SaleOnMainPage::widget(); ?>

        <!-- Причины выбрать нас -->
        <div class="causes">
            <div class="container large-container">
                <div class="row">
                    <h2>3 причины выбрать нас</h2>
                    <div class="causes-in">

                        <div class="col-md-4">
                            <div class="one-cause">
                                <div class="big sofa">
                                    65 735
                                </div>
                                <div class="descr">
                                    Товаров для интерьера из Италии
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="one-cause">
                                <div class="big italy">
                                    Лучший
                                </div>
                                <div class="descr">
                                    Поставщик товаров из Италии в Москве
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="one-cause">
                                <div class="big like">
                                    Сервис
                                </div>
                                <div class="descr">
                                    <ul>
                                        <li>Консультации</li>
                                        <li>Подбор</li>
                                        <li>Доставка</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="to-cat btn btn-default">
                            Перейти в каталог
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- Конец причины выбрать нас -->

        <?= FactoryOnMainPage::widget(); ?>

        <!-- факторы -->
        <div class="factories">
            <div class="container large-container">
                <div class="row">
                    <div class="text">
                        <p>
                            Вот уже много десятилетий лет <b>итальянская мебель</b> не просто не теряет своей
                            актуальности,
                            но и уверенно лидирует в списках приобретений самых взыскательных и капризных клиентов.
                            <b>Итальянская мебель</b> – это гармоничное сочетание роскоши и практичности, изысканности,
                            неординарности и, вместе с тем, неповторимой эстетичности, стиля и изящества. Не стоит
                            также забывать про такие важные для современного потребителя свойства,
                            как эргономичность, комфорт, функциональность и главное разные ценовые сегменты.
                        </p>
                        <p>
                            Все эти преимущества в едином сочетании – вот главное преимущество, которым
                            отличается <b>элитная мебель из Италии</b> от множества аналогов от производителей из других
                            стран.
                            <b>Элитная мебель</b> Италии всегда занимала особенное место в сердцах любителей
                            прекрасного.
                            С её помощью легко преображать помещения любого типа, а сами изделия подчас настолько
                            изысканы, что с легкостью могут тягаться с произведениями искусства.
                            Италия – признанный лидер в производстве авторских моделей мебели, а итальянская мебель
                            уже не первое столетние задает тон мебельной моде всего прогрессивного мира.
                        </p>
                        <p>
                            Сколько бы ни прошло времени (речь идет о годах и даже десятилетиях),
                            итальянская мебель не теряет своей актуальности, спрос на нее остается по-прежнему
                            высоким и стабильным!
                        </p>
                        <p>
                            Порой, элитная мебель Италии несет в себе такие, казалось бы несовместимые на
                            первый взгляд качества, как способность сочетаться практически с любыми стилями оформления
                            интерьеров и в то же самое время – соответствие вековым традициям мебельной моды,
                            характерным для элитных гарнитуров и ансамблей. В оригинальных по дизайну и отделке
                            предметах
                            мебели так просто и без излишней «пафосности», естественным и гармоничным образом могут
                            сочетаться неповторимый колорит и современные тенденции в мире мебельной моды.
                            Также можно упомянуть такое сочетание, как практичность и эргономичный дизайн с одной
                            стороны,
                            а также роскошь и неповторимость – с другой.
                        </p>
                        <p>
                            Важно понимать, что элитная итальянская мебель – это не просто один из многочисленных
                            вариантов убранства вашего жилища, это выражение определенной психологии и философии жизни
                            ее владельцев, молчаливый показатель изысканного вкуса и финансового благосостояния.
                            Неспешно и с комфортом выбрать, а также купить итальянскую мебель для самых красивых и
                            эксклюзивных интерьеров в Москве.
                        </p>
                        <h2>
                            Почему стоит покупать итальянскую мебель
                        </h2>
                        <p>
                            Чтобы вы смогли ознакомиться с самыми актуальными предложениями любой салон итальянской
                            мебели в Москве MYARREDO предоставит удобный каталог, в котором вы наверняка
                            сможете найти мебель вашей мечты. Менеджеры и дизайнеры пригласят в уютный
                            офис или салон, предложат в приятной атмосфере за чашечкой настоящего итальянского кофе
                            обсудить ваши пожелания, дадут наиболее полную консультацию по стилям, материалам и
                            всевозможным отделкам и конструкторским решениям. Мы предоставим лучшие цены и условия
                            покупки из всех предложений в Москве. С нашей помощью купить <b>итальянскую мебель</b> не
                            только
                            просто но и приятно и выгодно.
                        </p>
                        <p>
                            Купить <b>итальянскую мебель</b> - лучший способ наполнить свое жилище уютом и придать ему
                            индивидуальности. Салон итальянской мебели сети Myarredo в Москве предлагает своим
                            клиентам в Москве стать обладателями уникальной мебели и предметов интерьера,
                            изготовленных на лучших фабриках и мебельных мастерских Италии. В нашем каталоге вы
                            сможете найти тысячи эксклюзивных предметов, которые помогут украсить ваше жилище и
                            сделают быт более изысканным и утонченным. Для получения подробной информации позвоните в
                            магазин итальянской мебели сети Myarredo в Москве по указанным контактным телефонам.
                            Всего пара кликов или один звонок и элитная мебель Италии украшает ваш дом.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- конец Факторы -->

        <!-- контакты в Москве -->
        <div class="manager-request">
            <div class="title">
                <div class="quest">Не нашли что искали?</div>
                <div class="sm-title">НАШ МЕНЕДЖЕР ПОДБЕРЕТ МЕБЕЛЬ ПО ВАШИМ ПАРАМЕТРАМ</div>
                <a href="#" class="btn btn-default">
                    Контакты в Москве
                </a>
            </div>
        </div>
        <!-- конец контакты в Москве -->

        <!-- Отзывы -->
        <div class="reviews">
            <div class="container large-container">
                <div class="row">
                    <div id="reviews-slider" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner">
                            <div class="item active">
                                <blockquote class="blockquote">
                                    <div class="quote">
                                        Я работаю дизайнером интерьером и мне часто приходится искать
                                        подходящую мебель для своих клиентов. Я просто обожаю салоны
                                        итальянской мебели myARREDO. Здесь представлен такой огромный ассортимент
                                        эксклюзивной, стильной и элегантной итальянской мебели!
                                        На мой взгляд, это лучший магазин, где можно приобрести итальянскую
                                        мебель. К тому же доставку и сборку осуществляют очень
                                        быстро и профессионально! Не могу менеджеров магазина не
                                        отметить – настоящие профессионалы своего дела!
                                    </div>
                                    <div class="signature">
                                        <span>ВЕРОНИКА</span> 15 ИЮЛЯ 2014
                                    </div>
                                </blockquote>
                            </div>

                            <div class="item">
                                <blockquote class="blockquote">
                                    <div class="quote">
                                        Почти всю мебель для нашего дома я заказывала в этом магазине.
                                        Когда увидела их сайт, их каталог, сразу же влюбилась. С помощью их менеджеров
                                        и дизайнеров мы подобрали самые лучшую мебель, которая очень хорошо вписалась
                                        в интерьер и сочеталась друг с другом. Все доставили, собрали – такой сервис
                                        отличный. Причем цены значительно ниже, чем в московских салонах с такой же
                                        итальянской мебелью.
                                    </div>
                                    <div class="signature">
                                        <span>ИРИНА</span> 17 ИЮЛЯ 2014
                                    </div>
                                </blockquote>
                            </div>

                        </div>

                        <div class="arr-cont">
                            <a class="left left-arr" href="#reviews-slider" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <div class="indent"></div>
                            <a class="right right-arr" href="#reviews-slider" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- Конец Отзывы -->
        <div id="map"></div>
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

$this->registerJs($script, yii\web\View::POS_END);

$this->registerJsFile(
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyDI-EyYe0E1ZPA9IpCTUbP2137VDAcHJGY',
    [
        'position' => yii\web\View::POS_END,
    ]
);

?>

<?= $content ?>

<?php $this->endContent(); ?>
