<?php

use yii\helpers\{
    Html, Url
};
use frontend\components\Breadcrumbs;
//
use frontend\modules\catalog\widgets\filter\{
    ProductSorting, ProductFilter
};

/**
 * @var $pages \yii\data\Pagination
 * @var $model \frontend\modules\catalog\models\Product
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row">
                <?= Html::tag('h1', $this->context->SeoH1); ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>
            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-3 col-lg-3">

                        <?= ProductFilter::widget([
                            'route' => '/catalog/category/list',
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
                                    из <?= $pages->getPageCount(); ?>
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

                        <?= $this->context->SeoContent ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
