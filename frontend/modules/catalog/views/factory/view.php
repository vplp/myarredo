<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = [
    'label' => 'Итальянские фабрики мебели',
    'url' => ['/catalog/factory/list']
];
$this->params['breadcrumbs'][] = [
    'label' => $model['lang']['title'],
    'url' => ['/catalog/factory/list']
];

?>

<main>
    <div class="page factory-page">
        <div class="letter-nav">
            <div class="container large-container">
                <ul class="letter-select">
                    <li>
                        <a href="#">a</a>
                    </li>
                    <li>
                        <a href="#">b</a>
                    </li>
                    <li>
                        <a href="#">c</a>
                    </li>
                    <li>
                        <a href="#">d</a>
                    </li>
                    <li>
                        <a href="#">e</a>
                    </li>
                    <li>
                        <a href="#">f</a>
                    </li>
                    <li>
                        <a href="#">g</a>
                    </li>
                    <li>
                        <a href="#">h</a>
                    </li>
                    <li>
                        <a href="#">i</a>
                    </li>
                    <li>
                        <a href="#">j</a>
                    </li>
                    <li>
                        <a href="#">k</a>
                    </li>
                    <li>
                        <a href="#">l</a>
                    </li>
                    <li>
                        <a href="#">m</a>
                    </li>
                    <li>
                        <a href="#">n</a>
                    </li>
                    <li>
                        <a href="#">o</a>
                    </li>
                    <li>
                        <a href="#">p</a>
                    </li>
                    <li>
                        <a href="#">r</a>
                    </li>
                    <li>
                        <a href="#">s</a>
                    </li>
                    <li>
                        <a href="#">t</a>
                    </li>
                    <li>
                        <a href="#">u</a>
                    </li>
                    <li>
                        <a href="#">v</a>
                    </li>
                    <li>
                        <a href="#">w</a>
                    </li>
                    <li>
                        <a href="#">x</a>
                    </li>
                    <li>
                        <a href="#">y</a>
                    </li>
                    <li>
                        <a href="#">z</a>
                    </li>
                </ul>
                <a href="#" class="all">
                    Все
                </a>
            </div>
        </div>
        <div class="container large-container">
            <div class="row">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => ['class' => 'bread-crumbs']
                ]) ?>
            </div>
            <div class="row factory-det">
                <div class="col-sm-3 col-md-3">
                    <div class="fact-img">
                        <img src="public/img/pictures/fact-det.png" alt="Логотип фабрики">
                    </div>
                </div>
                <div class="col-sm-9 col-md-9">
                    <div class="descr">
                        <h1 class="title-text"><?= $model['lang']['title']; ?></h1>
                        <div class="fact-link">
                            <a href="#">WWW.ARARREDAMENTI.IT</a>
                        </div>
                        <div class="fact-assort">
                            <div class="all-list">
                                <a href="#" class="title">
                                    Все предметы мебели
                                </a>
                                <ul class="list">
                                    <li>
                                        <a href="#">
                                            Банкетка (3)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барная стойка (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барный стол (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барный стул (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Бра (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Буфет (23)
                                        </a>
                                    </li>
                                </ul>
                                <ul class="list post-list">
                                    <li>
                                        <a href="#">
                                            Банкетка (3)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барная стойка (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барный стол (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барный стул (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Бра (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Буфет (23)
                                        </a>
                                    </li>
                                </ul>
                                <a href="javascript:void(0);" class="view-all">
                                    Весь список
                                </a>
                            </div>
                            <div class="all-list">
                                <a href="#" class="title">
                                    Все коллекции
                                </a>
                                <ul class="list">
                                    <li>
                                        <a href="#">
                                            AMADEUS (3)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            CELEBRITY (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            DOLCE VITA (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            EXSELCIOR (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            GRAND RYAL (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            HARMONY (23)
                                        </a>
                                    </li>
                                </ul>
                                <ul class="list post-list">
                                    <li>
                                        <a href="#">
                                            AMADEUS (3)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            CELEBRITY (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            DOLCE VITA (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            EXSELCIOR (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            GRAND RYAL (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            HARMONY (23)
                                        </a>
                                    </li>
                                </ul>
                                <a href="javascript:void(0);" class="view-all">
                                    Весь список
                                </a>

                            </div>
                        </div>
                        <div class="text">
                            <p>
                                Итальянская мебельная компания AR Arredamenti имеет длинную и интересную историю.
                                Она была основана в прошлом веке – в 1967 году – в качестве ремесленной мастерской
                                талантливых краснодеревщиков, искренне преданных избранной профессии.
                                В 1986 году произошло значительное расширение производства, переход на новый
                                качественный уровень, начался рост во всех смыслах. Сотрудничество с лучшими
                                дизайнерами, обновление коллекций, приверженность классическим
                                традициям помогли заслужить отличную репутацию бренда, отвечающего и
                                за качество, и за стиль своей продукции.
                            </p>
                            <p>
                                В ассортименте, предлагаемом клиентам компании на сегодняшний день, представлена
                                мебель для жилых помещений: кабинетов, столовых, гостиных, спален – наиболее значимых
                                и важных зон каждого дома. Свойственная этим моделям изысканная роскошь,
                                элегантный шик и неизменная красота, которую невозможно не заметить,
                                выгодно отличает мебель от AR Arredamenti, ставит ее на порядок выше
                                продукции большинства современных брендов.
                            </p>
                            <p>
                                Для того чтобы добиться непревзойденного качества, компания AR Arredamenti
                                не просто применила все имеющиеся знания и умения, опыт своих квалифицированных
                                сотрудников и традиционные способы производства, которые передавались от одного
                                поколения итальянских краснодеревщиков к другому, но и сделала ставку на
                                современное оборудование, художественный талант и тонкое чутье моды
                                дизайнеров и высочайший уровень используемых материалов. Результат
                                не заставил себя ждать. Известность, множество благодарных клиентов
                                в разных странах мира, рекомендации друзьям и близким –
                                эта мебель неизменно востребована, ведь она производится
                                одним из лидеров мебельной промышленности Европы, успешным брендом
                                AR Arredamenti, чье имя равнозначно качеству и стилю.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row menu-style">
                <a href="#">
                    Все
                </a>
                <a href="#">
                    Аксессуары
                </a>
                <a href="#">
                    Гостиные
                </a>
                <a href="#">
                    Кабинеты
                </a>
                <a href="#">
                    Кухни
                </a>
                <a href="#">
                    Мебель для TV
                </a>
                <a href="#">
                    Мебель для ресторанов
                </a>
                <a href="#">
                    Мягкая мебель
                </a>
                <a href="#">
                    Прихожие
                </a>
                <a href="#">
                    Светильники
                </a>
                <a href="#">
                    Спальни
                </a>
                <a href="#">
                    Столовые комнаты
                </a>
                <a href="#">
                    Стулья
                </a>
            </div>

            <div class="cat-prod catalog-wrap">
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat1.jpeg" alt="">
                        <div class="brand">
                            ANGELO CAPPELLINI
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat2.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile last">
                    смотреть полный
                    <div>
                        Каталог
                    </div>
                </a>
            </div>


        </div>
    </div>
</main>
