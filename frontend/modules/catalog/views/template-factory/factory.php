<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\catalog\models\Factory;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 */

$keys = Yii::$app->catalogFilter->keys;

$this->title = $this->context->title;

?>

    <div class="tom-header">
        <div class="container large-container">
            <div class="top-topm-header flex">
                <div class="logo-cont">
                    <?= Html::img(Factory::getImage($model['image_link'])); ?>
                </div>

                <?= Html::tag(
                    'h3',
                    $model['lang']['h1'] . ', купить в ' . Yii::$app->city->getCityTitleWhere()
                ); ?>

            </div>
            <a href="tel:+74951502121" class="tel">
                +7 (495) 150-21-21
            </a>
            <nav class="nav">
                <a href="#">Каталог мебели</a>
                <a href="#">Контанты</a>
            </nav>
        </div>
    </div>

    <div class="tom-cont">

        <div class="container large-container">
            <div class="fact-slider">
                <div class="img-cont">
                    <img src="public/img/tomassy_slider/slider1.jpg" alt="">
                    <span>CLASSIC COLECTION 2016</span>
                </div>
                <div class="img-cont">
                    <img src="public/img/tomassy_slider/slider2.jpg" alt="">
                    <span>CLASSIC COLECTION 2016</span>
                </div>
                <div class="img-cont">
                    <img src="public/img/tomassy_slider/slider3.jpg" alt="">
                    <span>CLASSIC COLECTION 2016</span>
                </div>
            </div>
        </div>

        <div class="text-description">
            <div class="container large-container">
                <div class="text-col">
                    <?= $model['lang']['content'] ?>
                </div>
            </div>
        </div>

        <div class="cat-container">
            <div class="container large-container">
                <?= Html::tag(
                    'h3',
                    $model['lang']['title'] . ' | Купить в ' . Yii::$app->city->getCityTitleWhere()
                ); ?>
                <div class="submenu">

                    <?php
                    $key = 1;
                    $FactoryCategory = Factory::getFactoryCategory([$model['id']]);

                    foreach ($FactoryCategory as $item) {
                        $params = Yii::$app->catalogFilter->params;

                        $params[$keys['factory']][] = $model['alias'];
                        $params[$keys['category']][] = $item['alias'];

                        echo Html::a(
                            $item['title'],
                            Yii::$app->catalogFilter->createUrl($params)
                        );
                    } ?>

                </div>
                <div class="cat-prod">

                    <?php foreach ($product as $item) {
                        echo $this->render('/category/_list_item', [
                            'model' => $item,
                            'factory' => [$model->id => $model]
                        ]);
                    }

                    echo Html::a(
                        'смотреть полный<div>Каталог</div>',
                        Yii::$app->catalogFilter->createUrl(
                            Yii::$app->catalogFilter->params + [$keys['factory'] => $model['alias']]
                        ),
                        ['class' => 'full-cat']
                    ); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="top-footer">
        <div class="container large-container">
            <div class="get-consl">
                <p>Получить консультацию в <?= Yii::$app->city->getCityTitleWhere() ?></p>
                <p>+7 (495) 150-21-21</p>
                <p>Студия Триумф</p>
                <p>улица Удальцова, 1А</p>
            </div>
            <div class="flex copy-r">
                <div>
                    2015 - <?= date('Y'); ?> (С) MYARREDO, ЛУЧШАЯ МЕБЕЛЬ ИЗ ИТАЛИИ ДЛЯ ВАШЕГО ДОМА
                </div>
                <div class="fund">Программирование сайта - <a href="http://www.vipdesign.com.ua/">VipDesign</a>
                </div>
            </div>
        </div>
    </div>

<?php
$script = <<<JS
    $('.fact-slider').slick({
    autoplay: true,
    dots: true,
    arrows: false,
    fade: true,
    cssEase: 'linear',
    autoplaySpeed: 3000
    });
JS;

$this->registerJs($script, yii\web\View::POS_END);
