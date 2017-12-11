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
