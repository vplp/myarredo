<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\{
    Factory, Sale
};
use frontend\modules\catalog\widgets\sale\SaleRequestForm;
use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);
/**
 * @var \frontend\modules\catalog\models\Sale $model
 */

$this->title = $this->context->title;

?>

    <main>
        <div class="page sale-page prod-card-page">
            <div class="container-wrap">
                <div class="container large-container">

                    <div class="row sale-prod">
                        <div class="col-md-12">
                            <div class="section-header">
                                <h2><?= Yii::t('app', 'Распродажа итальянской мебели') ?></h2>
                                <?= Html::a(
                                    Yii::t('app', 'Вернуться к списку'),
                                    Url::toRoute(['/catalog/sale/list']),
                                    ['class' => 'back']
                                ); ?>
                            </div>
                        </div>
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
                                        <?= ($model['factory']) ? $model['factory']['title'] : $model['factory_name'] ?>
                                    </td>
                                </tr>
                                <?php if (!empty($model['specificationValue'])) {
                                    $array = [];
                                    foreach ($model['specificationValue'] as $item) {
                                        if ($item['specification']['parent_id'] == 9) {
                                            $array[] = $item['specification']['lang']['title'];
                                        }
                                    }
                                    if (!empty($array)) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Стиль') ?></td>
                                            <td>
                                                <?= implode('; ', $array) ?>
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
                                                        ':' .
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
                                    if (!empty($array)) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Материал') ?></td>
                                            <td>
                                                <?= implode('; ', $array) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>

                            <div class="prod-shortstory">
                                <?= $model['lang']['description']; ?>
                            </div>

                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

                            <?php if (!empty($model['user'])) { ?>
                                <div class="brand-info">
                                    <div class="white-area">
                                        <div class="image-container">
                                            <img src="<?= $bundle->baseUrl ?>/img/brand.png" alt="">
                                        </div>
                                        <div class="brand-info">
                                            <p class="text-center">
                                                <?= Yii::t('app', 'Контакты продавца') ?>
                                            </p>
                                            <h4 class="text-center">
                                                <?= $model['user']['profile']['name_company']; ?>
                                            </h4>
                                            <div class="ico">
                                                <img src="<?= $bundle->baseUrl ?>/img/phone.svg" alt="">
                                            </div>
                                            <div class="tel-num js-show-num">
                                                (XXX) XXX-XX-XX
                                            </div>

                                            <a href="javascript:void(0);" class="js-show-num-btn">
                                                Узнать номер
                                            </a>

                                            <div class="ico">
                                                <img src="<?= $bundle->baseUrl ?>/img/marker-map.png" alt="">
                                            </div>
                                            <div class="text-center adress">
                                                <?= $model['user']['profile']['city']['lang']['title']; ?>,<br>
                                                <?= $model['user']['profile']['address']; ?>
                                            </div>

                                            <div class="ico">
                                                <img src="<?= $bundle->baseUrl ?>/img/conv.svg" alt="">
                                            </div>
                                            <a href="javascript:void(0);" class="write-seller" data-toggle="modal"
                                               data-target="#myModal">
                                                написать продавцу
                                            </a>

                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?= SaleRequestForm::widget(['sale_item_id' => $model['id']]) ?>


<?php
$user_id = $model['user']['id'];
$sale_item_id = $model['id'];
$script = <<<JS
$('.js-show-num-btn').on('click', function () {
    $.post(
        '/catalog/sale/ajax-get-phone/', 
        {_csrf: $('#token').val(), user_id: $user_id, sale_item_id: $sale_item_id}, 
        function(data){
            $('.js-show-num').html(data.phone);
            $('.js-show-num-btn').remove();
        }, 
        'json'
    );
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);