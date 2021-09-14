<?php

use yii\helpers\{
    Html, Url
};
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{Factory, Product, ProductLang};
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\shop\widgets\request\RequestPrice;
use frontend\modules\catalog\widgets\product\ViewedProducts;

/**
 * @var $model Product
 */

$bundle = AppAsset::register($this);

$products_id = [];
foreach (Yii::$app->shop_cart->items as $item) {
    $products_id[] = $item->product_id;
}

$keys = Yii::$app->catalogFilter->keys;

$this->title = $this->context->title;
?>

    <main>
        <div class="prod-card-page page">
            <div class="container-wrap">
                <div class="container large-container">
                    <?php if (!isset($this->context->factory)) { ?>
                        <?= Breadcrumbs::widget([
                            'links' => $this->context->breadcrumbs,
                        ]) ?>
                    <?php } ?>
                    <div class="row" itemscope itemtype="http://schema.org/Product">

                        <div class="col-sm-6 col-md-6 col-lg-5">

                            <?= $this->render('parts/_carousel', [
                                'model' => $model
                            ]); ?>

                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <?php if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter'])) {
                                echo Html::a(
                                    Yii::t('app', 'Edit'),
                                    ($model['is_composition'])
                                        ? '/backend/catalog/compositions/update?id=' . $model['id']
                                        : '/backend/catalog/product/update?id=' . $model['id'],
                                    [
                                        'target' => '_blank'
                                    ]
                                );
                            } ?>
                            <div class="product-title">
                                <?= Html::tag(
                                    'h1',
                                    $model->getTitle(),
                                    ['class' => 'prod-model', 'itemprop' => 'name']
                                ); ?>
                            </div>
                            <div class="prod-info-table">
                                <div class="price-availability" itemprop="offers" itemscope
                                     itemtype="http://schema.org/Offer">

                                    <?php if ($model['price_from'] > 0 && !Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter', 'partner'])) { ?>
                                        <div class="price-sticker">
                                            <?= Yii::t('app', 'Цена от') ?><span>&#126;</span>
                                            <span><?= Yii::$app->currency->getValue($model['price_from'], $model['currency']); ?>
                                            &nbsp;<span class="currency"><?= Yii::$app->currency->symbol ?></span></span>
                                        </div>
                                    <?php } ?>

                                    <?php /*if (Yii::$app->city->isShowPrice() && !$model['removed'] && $model['price_from'] > 0) { ?>
                                    <div class="price-sticker">
                                        <?= Yii::t('app', 'Цена от') ?><span>&#126;</span>
                                        <span>
                                        <?= Yii::$app->currency->getValue($model['price_from'], $model['currency']); ?>
                                            &nbsp;<span class="currency"><?= Yii::$app->currency->symbol ?></span>
                                            <meta itemprop="price"
                                                  content="<?= Yii::$app->currency->getValue($model['price_from'], $model['currency'], ''); ?>">
                                            <meta itemprop="priceCurrency" content="<?= Yii::$app->currency->code ?>"/>
                                    </span>
                                    </div>
                                <?php } else { ?>
                                    <meta itemprop="price" content="0"/>
                                    <meta itemprop="priceCurrency" content="EUR"/>
                                <?php }*/ ?>

                                    <meta itemprop="price" content="<?= $model['price_from'] ?>"/>
                                    <meta itemprop="priceCurrency" content="<?= $model['currency'] ?>"/>

                                    <div class="availability">
                                        <?= Yii::t('app', 'Наличие') ?>:
                                        <span><?= Product::getStatus($model) ?></span>
                                        <?php if (!$model->removed && $model->in_stock) { ?>
                                            <meta itemprop="availability" content="InStock"/>
                                        <?php } elseif (!$model->removed) { ?>
                                            <meta itemprop="availability" content="PreOrder"/>
                                        <?php } ?>
                                        <meta itemprop="priceValidUntil" content="<?= date('Y-m-d') ?>"/>
                                        <link itemprop="url" href="<?= Product::getUrl($model[Yii::$app->languages->getDomainAlias()]) ?>"/>
                                    </div>

                                    <?php if (!in_array(Yii::$app->controller->action->id, ['product'])) {
                                        if (!in_array($model['id'], $products_id)) {
                                            echo Html::a(
                                                Yii::t('app', 'Отложить в блокнот'),
                                                'javascript:void(0);',
                                                [
                                                    'class' => 'add-to-notepad btn btn-default big',
                                                    'data-id' => $model['id'],
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#myModal',
                                                    'data-message' => Yii::t('app', 'В блокноте')
                                                ]
                                            );
                                        } else {
                                            echo Html::a(
                                                Yii::t('app', 'В блокноте'),
                                                'javascript:void(0);',
                                                [
                                                    'class' => 'btn btn-default big',
                                                ]
                                            );
                                        }
                                    } ?>

                                </div>

                                <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                    <meta itemprop="ratingValue" content="5"/>
                                    <meta itemprop="bestRating" content="5"/>
                                    <meta itemprop="ratingCount" content="1"/>
                                    <meta itemprop="reviewCount" content="1"/>
                                </div>
                                <div itemprop="review" itemscope itemtype="http://schema.org/Review">
                                    <meta itemprop="author" content="user">
                                </div>

                                <table class="info-table">
                                    <?php if ($model['subTypes'] != null) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Типы') ?></td>
                                            <td>
                                                <?php
                                                $array = [];
                                                $paramsUrl = [];
                                                foreach ($model['subTypes'] as $item) {
                                                    $array[] = $item['lang']['title'];
                                                    $paramsUrl[$keys['subtypes']][] = $item['alias'];
                                                }

                                                echo Html::a(
                                                    implode('; ', $array),
                                                    Yii::$app->catalogFilter->createUrl($paramsUrl)
                                                );
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($model['specificationValue'] != null) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Стиль') ?></td>
                                            <td>
                                                <?php
                                                $array = [];
                                                $paramsUrl = [];
                                                foreach ($model['specificationValue'] as $item) {
                                                    if ($item['specification']['parent_id'] == 9) {
                                                        $array[] = $item['specification']['lang']['title'];

                                                        $paramsUrl[$keys['style']][] = $item['specification'][Yii::$app->languages->getDomainAlias()];
                                                    }
                                                }

                                                if ($model['types']) {
                                                    $paramsUrl[$keys['type']][] = $model['types'][Yii::$app->languages->getDomainAlias()];
                                                }

                                                echo Html::a(
                                                    implode('; ', $array),
                                                    Yii::$app->catalogFilter->createUrl($paramsUrl, ['/catalog/countries-furniture/list'])
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($model['factory'] != null) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Factory') ?></td>
                                            <td>
                                                <meta itemprop="brand" content="<?= $model['factory']['title'] ?>"/>
                                                <?= Html::a(
                                                    $model['factory']['title'],
                                                    Factory::getUrl($model['factory']['alias'])
                                                ); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($model['collections_id']) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Коллекция') ?></td>
                                            <td>
                                                <?= Html::a(
                                                    $model['collection']['title'] ?? '',
                                                    Yii::$app->catalogFilter->createUrl(
                                                        Yii::$app->catalogFilter->params +
                                                        [$keys['factory'] => $model['factory']['alias']] +
                                                        [$keys['collection'] => $model['collection']['id']],
                                                        ['/catalog/countries-furniture/list']
                                                    )
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <meta itemprop="sku" content="<?= $model['article'] ?>">

                                    <?php if (!$model['is_composition']) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Артикул') ?></td>
                                            <td>
                                                <?= $model['article']; ?>
                                            </td>
                                        </tr>

                                        <?php if (!empty($model['specificationValue'])) { ?>
                                            <?php
                                            $array = [];
                                            foreach ($model['specificationValue'] as $item) {
                                                if ($item['specification']['parent_id'] == 4 && $item['val']) {
                                                    $array[] = Html::beginTag('div') .
                                                        $item['specification']['lang']['title'] .
                                                        ' (' . Yii::t('app', 'см') . ')' .
                                                        ': ' .
                                                        $item['val'] .
                                                        Html::endTag('div');
                                                }
                                            }
                                            if (!empty($array)) { ?>
                                                <tr>
                                                    <td><?= Yii::t('app', 'Размеры') ?></td>
                                                    <td>
                                                        <?= implode(' ', $array) ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>

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
                                    <?php } ?>

                                </table>

                                <?= $this->render('parts/_factory_files', [
                                    'model' => $model
                                ]); ?>

                                <div class="prod-descr"
                                     itemprop="description"><?= $model['lang']['description']; ?></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-3">

                            <?php if (!$model['removed']) { ?>
                                <div class="best-price-form">
                                    <h3><?= Yii::t('app', 'Заполните форму - получите лучшую цену на этот товар') ?></h3>
                                    <?= RequestPrice::widget(['product_id' => $model['id']]) ?>
                                </div>

                            <?php } else { ?>
                                <?= Yii::t(
                                    'app',
                                    'Данный товар снят с протзводства. Но мы можем предложить альтернативную модель.'
                                ) ?>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="row composition"></div>

                    <div class="best-price">
                        <div>
                            <div class="section-header">
                                <h3 class="section-title">
                                    <?= Yii::t('app', 'Как мы получаем лучшие цены для вас?') ?>
                                </h3>
                            </div>
                            <div class="numbers js-numbers">
                                <div class="one-number">
                                    <div class="title">
                                        1
                                        <div class="img-cont">
                                            <?= Html::img($bundle->baseUrl . '/img/num1.svg',  ['width' => '105', 'height' => '105']) ?>
                                        </div>
                                    </div>
                                    <div class="descr">
                                        <?= Yii::t(
                                            'app',
                                            'Ваш запрос отправляется всем поставщикам, авторизированным в нашей сети MY ARREDO FAMILY.'
                                        ) ?>
                                    </div>
                                </div>
                                <div class="one-number">
                                    <div class="title">
                                        2
                                        <div class="img-cont">
                                            <?= Html::img($bundle->baseUrl . '/img/num2.svg',  ['width' => '105', 'height' => '105']) ?>
                                        </div>
                                    </div>
                                    <div class="descr">
                                        <?= Yii::t(
                                            'app',
                                            'Самые активные и успешные профессионалы рассчитают для вас лучшие цены.'
                                        ) ?>
                                    </div>
                                </div>
                                <div class="one-number">
                                    <div class="title">
                                        3
                                        <div class="img-cont" style="margin-top: 0;">
                                            <?= Html::img($bundle->baseUrl . '/img/num3.svg',  ['width' => '105', 'height' => '105']) ?>
                                        </div>
                                    </div>
                                    <div class="descr">
                                        <?= Yii::t('app', 'Вы получите предложения и останется только выбрать лучшее по цене и условиям.') ?>
                                    </div>
                                </div>
                                <div class="one-number">
                                    <div class="title">
                                        4
                                        <div class="img-cont">
                                            <?= Html::img($bundle->baseUrl . '/img/num4.svg',  ['width' => '105', 'height' => '105']) ?>
                                        </div>
                                    </div>
                                    <div class="descr">
                                        <?= Yii::t('app', 'Партнеры сети MY ARREDO FAMILY получают дополнительные скидки от фабрик и предоставляют лучшие цены Вам.') ?>
                                    </div>
                                </div>
                                <div class="one-number">
                                    <div class="title">
                                        5
                                        <div class="img-cont">
                                            <?= Html::img($bundle->baseUrl . '/img/num5.svg',  ['width' => '105', 'height' => '105']) ?>
                                        </div>
                                    </div>
                                    <div class="descr">
                                        <?= Yii::t('app', 'В сети MY ARREDO FAMILY только проверенные поставщики, которые подтвердили свою надежность.') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="best-price">
                        <div>
                            <div class="after-text">
                                <div class="img-container">
                                    <?= Html::img($bundle->baseUrl . '/img/hand.svg', ['width' => '290', 'height' => '60', 'loading' => 'lazy']) ?>
                                </div>
                                <div class="text-contain">
                                    <?= Yii::t('app', 'Экономьте время и усилия на поиск по множеству сайтов. Все лучшие и проверенные поставщики собраны в нашей сети.') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($model['collections_id']) {
                        echo $this->render('parts/_product_by_collection', [
                            'collection' => $model['collection'],
                            'models' => $model->getProductByCollection($model['collections_id'], $model['catalog_type_id'])
                        ]);
                    } ?>

                    <?php if ($model['collections_id']) {
                        echo $this->render('parts/_product_by_factory', [
                            'factory' => $model['factory'],
                            'types' => $model['types'],
                            'models' => $model->getProductByFactory($model['factory_id'], $model['catalog_type_id'])
                        ]);
                    } ?>

                </div>
            </div>
        </div>

        <div id="decoration-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <div class="modal-content">
                    <div class="image-container"></div>
                </div>
            </div>
        </div>

    </main>

<?php
$url = Url::to(['/catalog/product/ajax-get-compositions']);

$script = <<<JS
$.post('$url', {_csrf: $('#token').val(), product_id:{$model['id']}}, function(data){
    $('.composition').html(data.html);
    $(".prod-card-page .nav-tabs li a").eq(0).click();
    // Выжидаем некоторое время
    setTimeout(function() {
        slickInit();
    },400);
});
JS;

$this->registerJs($script);
