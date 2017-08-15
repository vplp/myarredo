<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
//
use frontend\modules\catalog\widgets\product\{
    ProductSorting, ProductFilter
};

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row">
                <?= Html::tag('h1', $this->context->title); ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                    'options' => ['class' => 'bread-crumbs']
                ]) ?>
            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-3 col-lg-3">

                        <?= ProductFilter::widget([
                            'category' => $category,
                            'types' => $types,
                            'style' => $style,
                            'factory' => $factory,
                        ]); ?>

                    </div>
                    <div class="col-md-9 col-lg-9">
                        <div class="cont-area">


                            <div class="hidden-xs hidden-sm top-bar flex">

                                <?= ProductSorting::widget(); ?>

                                <div class="this-page">
                                    Страница
                                    <input type="text" value="1">
                                    из <?= $pages->totalCount; ?>
                                    <a href="#">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </a>
                                </div>

                            </div>

                            <!--
                            <a href="#" class="hidden-xs large-baner">
                                <img src="public/img/pictures/large-baner.png" alt="">
                            </a>
                            -->

                            <!--
                            <div class="rec-products">
                                <div class="wrap">
                                    <h3>РЕКОМЕНДУЕМЫЕ ТОВАРЫ</h3>
                                </div>
                                <div class="slide multi-item3-carousel" id="rec-prod-slider">
                                    <div class="item active">
                                        <a href="#1" class="tile">
                                            <div class="img-cont">
                                                <img src="public/img/pictures/rec1.jpg" alt="">
                                            </div>
                                            <div class="add-item-text">
                                                Стул  STILE LEGNO 5086.017
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item">
                                        <a href="#1" class="tile">
                                            <div class="img-cont">
                                                <img src="public/img/pictures/rec2.png" alt="">
                                            </div>
                                            <div class="add-item-text">
                                                Стул  STILE LEGNO 5086.017
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item">
                                        <a href="#1" class="tile">
                                            <div class="img-cont">
                                                <img src="public/img/pictures/rec3.png" alt="">
                                            </div>
                                            <div class="add-item-text">
                                                Стул  STILE LEGNO 5086.017
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item">
                                        <a href="#1" class="tile">
                                            <div class="img-cont">
                                                <img src="public/img/pictures/rec2.png" alt="">
                                            </div>
                                            <div class="add-item-text">
                                                Стул  STILE LEGNO 5086.017
                                            </div>
                                        </a>
                                    </div>
                                    <div class="item">
                                        <a href="#1" class="tile">
                                            <div class="img-cont">
                                                <img src="public/img/pictures/rec1.jpg" alt="">
                                            </div>
                                            <div class="add-item-text">
                                                Стул  STILE LEGNO 5086.017
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            -->

                            <div class="cat-prod-wrap">
                                <div class="cat-prod">

                                    <?php

                                    $_types = $_factory = $_collection = [];

                                    foreach ($types as $item) {
                                        $_types[$item['id']] = $item;
                                    }

                                    foreach ($factory as $item) {
                                        $_factory[$item['id']] = $item;
                                    }

                                    foreach ($collection as $item) {
                                        $_collection[$item['id']] = $item;
                                    }

                                    foreach ($models as $model): ?>
                                        <?= $this->render('_list_item', [
                                            'model' => $model,
                                            'types' => $_types,
                                            'style' => $style,
                                            'factory' => $_factory,
                                            'collection' => $_collection,
                                        ]) ?>
                                    <?php endforeach; ?>

                                </div>
                                <div class="pagi-wrap">

                                    <?=
                                    yii\widgets\LinkPager::widget([
                                        'pagination' => $pages,
                                        'registerLinkTags' => true,
                                        'nextPageLabel' => 'Далее<i class="fa fa-angle-right" aria-hidden="true"></i>',
                                        'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>Назад'
                                    ]);
                                    ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="comp-advanteges">
                        <p>
                            Ищете вариант приобретения <strong>итальянской мебели</strong>, который избавит от рутинного
                            похода по
                            магазинам в поисках подходящего интерьерного решения? Салоны партнеры myARREDO в Москве
                            представят все необходимое для создания уютных эксклюзивных интерьеров.
                        </p>
                        <p>
                            Не хватит никаких по площади выставочных и торговых помещений, чтобы представить взору
                            покупателя максимально полный ассортимент и каталог <strong>итальянской мебели</strong>
                            доступной
                            сегодня к покупке. Шикарные гарнитуры и отдельные предметы <strong>итальянской
                                мебели</strong>, поражающие
                            воображение своим изысканным дизайном и практичностью при эксплуатации, представлены в
                            огромном разнообразии
                            цветовых и стилистических решений. Ознакомиться с ассортиментом элитной мебели из Италии
                            можно
                            при помощи каталога. Ассортимент наших партнеров представляет широкий выбор продукции от
                            всемирно известных мастеров производства <strong>итальянской мебели</strong>. Среди наших
                            предложений Вы найдете
                            то, что поможет создать именно Ваш интерьер мечты. Мы предлагаем эксклюзивную итальянскую
                            мебель
                            как премиум класса, достойную самых искушенных клиентов, так и варианты среднего ценового
                            сегмента,
                            критерии качества и красоты которой ничуть не уступают более дорогим экземплярам.
                            Итальянская мебель
                            это то, что поможет создать идеальный интерьер с минимальными затратами!
                        </p>
                        <p>
                            Итальянская мебель в Москве - лучший вариант для оформления изысканного интерьера!
                        </p>
                        <p>
                            Каталог <strong>итальянской мебели</strong> от салонов партнеров myARREDO в Москве состоит
                            более чем из
                            60 000 моделей и 250 самых последних коллекций мебели и аксессуаров, производимых фабриками
                            Италии.
                        </p>
                        <p>
                            Итальянскую мебель вы сможете выбрать для любой комнаты и различного
                            функционального назначения. Вашему вниманию наш каталог итальянской мебели представляет:
                        </p>
                        <ul>
                            <li>итальянская спальня</li>
                            <li>итальянская гардеробная</li>
                            <li>итальянская мягкая мебель</li>
                            <li>итальянская ванная</li>
                            <li>итальянский кабинет</li>
                            <li>итальянская гостиная</li>
                            <li>итальянская столовая</li>
                            <li>итальянская кухня</li>
                            <li>итальянская прихожая.</li>
                        </ul>
                        <h2>
                            Каталог итальянской мебели <strong>myARREDO</strong> - комфортный способ найти мебель на
                            любой вкус.
                        </h2>
                        <p>
                            Приобретение мебели с компанией партнером myARREDO в Москве станет идеальным
                            воплощением Ваших творческих идей в планировании интерьера. Если Вас привлекает
                            итальянская современная мебель или классическая мебель из Италии,
                            отредактируйте параметры фильтра в соответствии с предпочтениями,
                            указав функциональное назначение, стиль, фабрику и материал изделия.
                        </p>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
