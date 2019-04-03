<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    Factory, ItalianProduct, Product
};
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\shop\widgets\request\RequestPrice;
use frontend\modules\catalog\widgets\sale\SaleRequestForm;

$bundle = AppAsset::register($this);
/**
 * @var ItalianProduct $model
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

                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="prod-info">
                                <?= Html::tag('h1', $model->getTitle()); ?>

                                <?php if ($model->price > 0) { ?>
                                    <div class="old-price">
                                        <?= $model->price . ' ' . $model->currency; ?>
                                    </div>
                                <?php } ?>

                                <div class="prod-price">
                                    <div class="price">
                                        <?= Yii::t('app', 'Цена') ?>:
                                        <span>
                                        <?= $model->price_new . ' ' . $model->currency; ?>
                                    </span>
                                    </div>
                                    <?php if ($model->price > 0) { ?>
                                        <div class="price economy">
                                            <?= Yii::t('app', 'Экономия') ?>:
                                            <span>
                                            <?= ($model->price - $model->price_new) . ' ' . $model->currency; ?>
                                        </span>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <table class="info-table" width="100%">
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

                                            ($model['factory']) ? $params[$keys['factory']] = $model['factory']['alias'] : null;

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

                                    <tr>
                                        <td><?= Yii::t('app', 'Размеры') ?></td>
                                        <td class="product-size">
                                            <?php
                                            foreach ($model['specificationValue'] as $item) {
                                                if ($item['specification']['parent_id'] == 4) {
                                                    echo Html::beginTag('span') .
                                                        $item['specification']['lang']['title'] .
                                                        ' (' . Yii::t('app', 'см') . ')' .
                                                        ': ' .
                                                        $item['val'] .
                                                        Html::endTag('span');
                                                }
                                            } ?>
                                        </td>
                                    </tr>

                                    <?php
                                    $array = [];
                                    foreach ($model['specificationValue'] as $item) {
                                        if ($item['specification']['parent_id'] == 2) {
                                            $array[] = $item['specification']['lang']['title'];
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><?= Yii::t('app', 'Материал') ?></td>
                                        <td>
                                            <?= !empty($array)
                                                ? implode('; ', $array)
                                                : $model['lang']['material'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>

                            <div class="prod-shortstory">
                                <?= $model['lang']['description']; ?>
                            </div>
                        </div>

                        <?php if (Yii::$app->controller->id == 'sale-italy') { ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 sellout-cont">
                                <div class="best-price-form">
                                    <h3><?= Yii::t('app', 'Заполните форму - получите лучшую цену на этот товар') ?></h3>

                                    <?= RequestPrice::widget(['product_id' => $model['id']]) ?>

                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-12 sellout-box">
                            <div class="section-header">
                                <h2><?= Yii::t('app', 'Распродажа итальянской мебели') ?></h2>
                                <?= Html::a(
                                    Yii::t('app', 'Вернуться к списку'),
                                    Url::toRoute(['/catalog/sale-italy/list']),
                                    ['class' => 'back']
                                ); ?>
                            </div>
                        </div>
                    </div>

                    <?= $this->render('@app/modules/catalog/views/product/parts/_product_by_factory', [
                        'factory' => $model['factory'],
                        'types' => $model['types'],
                        'models' => Product::getProductByFactory($model['factory_id'], $model['catalog_type_id'])
                    ]) ?>

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

$this->registerJs($script, yii\web\View::POS_READY);