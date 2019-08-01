<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{Factory, ItalianProduct, Product};
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\shop\widgets\request\RequestPrice;
use frontend\modules\catalog\widgets\sale\SaleRequestForm;
use frontend\modules\catalog\widgets\product\ViewedProducts;

$bundle = AppAsset::register($this);
/**
 * @var $model ItalianProduct
 */

$this->title = $this->context->title;

?>

    <main>
        <div class="page sale-page prod-card-page">
            <div class="container-wrap">
                <div class="container large-container">
                    <div class="row">

                        <?= Breadcrumbs::widget([
                            'links' => $this->context->breadcrumbs,
                        ]) ?>

                    </div>

                    <div class="row sale-prod">
                        <div class="col-sm-6 col-md-6 col-lg-5">

                            <?= $this->render('parts/_carousel', [
                                'model' => $model
                            ]); ?>

                            <?php if ($model->catalog_type_id == 3 && $model->file_link) { ?>
                                <div>
                                    <?= Html::a(
                                        Yii::t('app', 'Смотреть проект'),
                                        $model->getFileLink(),
                                        ['target' => '_blank']
                                    ) ?>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="prod-info">
                                <?= Html::tag('h1', $model->getTitle()); ?>

                                <?php if ($model->price > 0) { ?>
                                    <div class="old-price">
                                        <?= Yii::$app->currency->getValue($model['price'], $model['currency']) . ' ' . Yii::$app->currency->symbol ?>
                                    </div>
                                <?php } ?>

                                <div class="prod-price">
                                    <div class="price">
                                        <?= Yii::t('app', 'Цена') ?>:
                                        <span><?= Yii::$app->currency->getValue($model['price_new'], $model['currency']) . ' ' . Yii::$app->currency->symbol ?></span>
                                    </div>
                                    <?php if ($model->price > 0) { ?>
                                        <div class="price economy">
                                            <?= Yii::t('app', 'Экономия') ?>:
                                            <span><?= Yii::$app->currency->getValue($model->price - $model->price_new, $model['currency']) . ' ' . Yii::$app->currency->symbol ?></span>
                                        </div>
                                    <?php } ?>
                                </div>

                                <?php if ($model->catalog_type_id == 3 && $model->price_without_technology) { ?>
                                    <div class="prod-price">
                                        <div class="price economy">
                                            <?= $model->getAttributeLabel('price_without_technology') ?>:
                                            <span><?= Yii::$app->currency->getValue($model['price_without_technology'], $model['currency']) . ' ' . Yii::$app->currency->symbol ?></span>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="alert" role="alert">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <?= Yii::t('app', 'Доставка товара от 20 дней') ?>
                                </div>
                            </div>

                            <table class="info-table itproduct-table" width="100%">
                                <?php if ($model['subTypes'] != null) { ?>
                                    <tr>
                                        <td><?= Yii::t('app', 'Типы') ?></td>
                                        <td>
                                            <?php
                                            $array = [];
                                            foreach ($model['subTypes'] as $item) {
                                                $array[] = $item['lang']['title'];
                                            }

                                            echo implode('; ', $array);
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td><?= Yii::t('app', 'Factory') ?></td>
                                    <td>
                                        <?= ($model['factory'])
                                            ? Html::a(
                                                $model['factory']['title'],
                                                Factory::getUrl($model['factory']['alias'])
                                            )
                                            : $model['factory_name'] ?>
                                    </td>
                                </tr>

                                <?php if (!empty($model['specificationValue'])) {
                                    $array = [];
                                    foreach ($model['specificationValue'] as $item) {
                                        if ($item['specification']['parent_id'] == 9) {
                                            $keys = Yii::$app->catalogFilter->keys;
                                            $params = Yii::$app->catalogFilter->params;
                                            $params[$keys['style']] = $item['specification']['alias'];

                                            ($model['factory'])
                                                ? $params[$keys['factory']] = $model['factory']['alias']
                                                : null;

                                            $array[] = [
                                                'title' => $item['specification']['lang']['title'],
                                                'url' => Yii::$app->catalogFilter->createUrl($params, '/catalog/sale/list')
                                            ];
                                        }
                                    }
                                    if (!empty($array)) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Стиль') ?></td>
                                            <td>
                                                <?php
                                                foreach ($array as $item) {
                                                    echo Html::a(
                                                        $item['title'],
                                                        $item['url']
                                                    );
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php
                                    $array = [];
                                    foreach ($model['specificationValue'] as $item) {
                                        if ($item['specification']['parent_id'] == 4 && $item['val']) {
                                            $array[] = Html::beginTag('span') .
                                                $item['specification']['lang']['title'] .
                                                ' (' . Yii::t('app', 'см') . ')' .
                                                ': ' .
                                                $item['val'] .
                                                Html::endTag('span');
                                        }
                                    }
                                    if (!empty($array)) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Размеры') ?></td>
                                            <td>
                                                <?= implode('; ', $array) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php
                                    $array = [];
                                    $nameSpecification = '';
                                    foreach ($model['specificationValue'] as $item) {
                                        if ($item['specification']['id'] == 60) {
                                            $nameSpecification = $item['specification']['lang']['title'];
                                            $array[] = $item['specificationByVal']['lang']['title'];
                                        }
                                    }
                                    if (!empty($array)) { ?>
                                        <tr>
                                            <td><?= $nameSpecification ?></td>
                                            <td>
                                                <?= implode('; ', $array) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php
                                    $array = [];

                                    if ($model['lang']['material']) {
                                        $array[] = $model['lang']['material'];
                                    }

                                    foreach ($model['specificationValue'] as $item) {
                                        if ($item['specification']['id'] == 2 && $item['val']) {
                                            $array[] = $item['specificationByVal']['lang']['title'];
                                        }
                                    }

                                    if (!empty($array)) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Материал') ?></td>
                                            <td>
                                                <?= implode('; ', $array) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                <?php } ?>

                                <?php if (!empty($model['colors'])) { ?>
                                    <tr>
                                        <td><?= $model->getAttributeLabel('colors_ids') ?></td>
                                        <td>
                                            <?php
                                            $array = [];
                                            foreach ($model['colors'] as $item) {
                                                $array[] = $item['lang']['title'];
                                            }
                                            echo implode('; ', $array);
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if ($model['production_year'] != '') { ?>
                                    <tr>
                                        <td><?= $model->getAttributeLabel('production_year') ?></td>
                                        <td>
                                            <?= $model['production_year'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if ($model['volume'] != '') { ?>
                                    <tr>
                                        <td><?= $model->getAttributeLabel('volume') ?></td>
                                        <td>
                                            <?= $model['volume'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if ($model['weight'] != '') { ?>
                                    <tr>
                                        <td><?= $model->getAttributeLabel('weight') ?></td>
                                        <td>
                                            <?= $model['weight'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>

                            <div class="prod-shortstory">
                                <?= $model['lang']['defects'] != ''
                                    ? Html::tag('strong', Yii::t('app', 'Defects'))
                                    . '<br>' .
                                    $model['lang']['defects']
                                    : null; ?>
                            </div>
                            <div class="prod-shortstory">
                                <?= $model['lang']['description'] != ''
                                    ? Html::tag('strong', Yii::t('app', 'Description'))
                                    . '<br>' .
                                    $model['lang']['description']
                                    : null; ?>
                            </div>
                        </div>

                        <?php if (Yii::$app->controller->id == 'sale-italy') { ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 sellout-cont">
                                <div class="best-price-form">
                                    <h3><?= Yii::t('app', 'Заполните форму - получите лучшую цену на доставку') ?></h3>

                                    <?= RequestPrice::widget(['product_id' => $model['id']]) ?>

                                </div>
                            </div>
                        <?php } ?>

                    </div>

                    <?php if (Yii::$app->controller->action->id == 'view') {
                        echo $this->render('@app/modules/catalog/views/product/parts/_product_by_factory', [
                            'factory' => $model['factory'],
                            'types' => $model['types'],
                            'models' => Product::getProductByFactory($model['factory_id'], $model['catalog_type_id'])
                        ]);

                        echo ViewedProducts::widget([
                            'modelClass' => ItalianProduct::class,
                            'cookieName' => 'viewed_sale_italy'
                        ]);
                    } ?>

                </div>
            </div>
        </div>
    </main>

<?php
if (Yii::$app->controller->id == 'sale-italy') {
    echo SaleRequestForm::widget(['sale_item_id' => $model['id']]);
}
?>

<?php
$user_id = $model['user']['id'];
$sale_item_id = $model['id'];
$url = Url::toRoute('/catalog/sale/ajax-get-phone');

$script = <<<JS
$('.js-show-num-btn').on('click', function () {
    $.post(
        '$url', 
        {_csrf: $('#token').val(), user_id: $user_id, sale_item_id: $sale_item_id}, 
        function(data){
            $('.js-show-num').html('<a href="tel:'+data.phone+'">'+data.phone+'</a>');
            $('.js-show-num-btn').remove();
        }, 
        'json'
    );
});
JS;

$this->registerJs($script);