<?php

use yii\helpers\{
    Html,
    Url
};
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{Factory, Product, ProductLang};
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\shop\widgets\request\{
    RequestPrice,
    RequestFindProduct
};
use frontend\modules\catalog\widgets\product\ViewedProducts;

/** @var $model Product */
/** @var $bestsellers */

$detect = new Mobile_Detect();

$bestsellers = $bestsellers ?? [];

$bundle = AppAsset::register($this);

$products_id = [];
foreach (Yii::$app->shop_cart->items as $item) {
    $products_id[] = $item->product_id;
}

$keys = Yii::$app->catalogFilter->keys;

$this->title = $this->context->title;
?>

    <main>
        <div class="prod-card-page page igalery">
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
                            <?php if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])) {
                                echo Html::a(
                                    Yii::t('app', 'Edit'),
                                    ($model->is_composition)
                                        ? '/backend/catalog/compositions/update?id=' . $model->id
                                        : '/backend/catalog/product/update?id=' . $model->id,
                                    [
                                        'target' => '_blank'
                                    ]
                                );
                            } ?>
                            <div class="product-title">
                                <?php if ($model->bestseller || in_array($model->id, $bestsellers)) { ?>
                                    <div class="prod-bestseller"><?= Yii::t('app', 'Bestseller') ?></div>
                                <?php } ?>

                                <?php if ($model->novelty) { ?>
                                    <div class="prod-novelty"><?= Yii::t('app', 'Novelty') ?></div>
                                <?php } ?>

                                <?= Html::tag(
                                    'h1',
                                    Product::getStaticTitle($model),
                                    ['class' => 'prod-model', 'itemprop' => 'name']
                                ); ?>

                                <?php if ($model->factory != null) { ?>
                                    <meta itemprop="brand" content="<?= $model->factory->title ?>">
                                <?php } ?>
                            </div>

                            <div class="prod-info-table">
                                <div class="price-availability tobox" itemprop="offers" itemscope
                                     itemtype="http://schema.org/Offer">

                                    <?php if (!$model->removed && $model->price_from > 0 && !Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter', 'partner', 'catalogEditor'])) { ?>
                                        <div class="price-sticker">
                                            <?= Yii::t('app', 'Цена от') ?><span>&#126;</span>
                                            <span><?= Yii::$app->currency->getValue($model->price_from, $model->currency); ?>
                                            &nbsp;<span class="currency"><?= Yii::$app->currency->symbol ?></span></span>
                                        </div>
                                    <?php } ?>

                                    <meta itemprop="price" content="<?= $model->price_from ?>"/>
                                    <meta itemprop="priceCurrency" content="<?= $model->currency ?>"/>

                                    <div class="availability">
                                        <?= Yii::t('app', 'Наличие') ?>:
                                        <span><?= Product::getStatus($model) ?></span>
                                        <?php if (!$model->removed && $model->in_stock) { ?>
                                            <meta itemprop="availability" content="InStock"/>
                                        <?php } elseif (!$model->removed) { ?>
                                            <meta itemprop="availability" content="PreOrder"/>
                                        <?php } ?>
                                        <meta itemprop="priceValidUntil" content="<?= date('Y-m-d') ?>"/>
                                        <link itemprop="url"
                                              href="<?= Product::getUrl($model->{Yii::$app->languages->getDomainAlias()}) ?>"/>
                                    </div>

                                    <?php if (!$model->removed) { ?>
                                        <?php if (!in_array(Yii::$app->controller->action->id, ['product'])) {
                                            if (!in_array($model->id, $products_id)) {
                                                echo Html::a(
                                                    '<i class="fa fa-heart" aria-hidden="true"></i>',
                                                    'javascript:void(0);',
                                                    [
                                                        'class' => 'add-to-notepad btn btn-default big',
                                                        'data-id' => $model->id,
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#myModal',
                                                        'data-message' => '<i class="fa fa-heart" aria-hidden="true"></i>',
                                                        'title' => Yii::t('app', 'Отложить в блокнот'),
                                                        'data-doned' => Yii::t('app', 'В блокноте')
                                                    ]
                                                );
                                            } else {
                                                echo Html::a(
                                                    '<i class="fa fa-heart" aria-hidden="true"></i>',
                                                    'javascript:void(0);',
                                                    [
                                                        'class' => 'btn btn-default big doned',
                                                        'title' => Yii::t('app', 'В блокноте')
                                                    ]
                                                );
                                            }
                                        } ?>
                                        <button class="btn-toform onlymob"><?= Yii::t('app', 'Получить лучшую цену') ?></button>
                                    <?php } ?>

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
                                    <?php if ($model->subTypes != null) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Типы') ?></td>
                                            <td>
                                                <?php
                                                $array = [];
                                                foreach ($model->subTypes as $item) {
                                                    $paramsUrl = [];

                                                    $paramsUrl[$keys['subtypes']][] = $item->alias;

                                                    $array[] = Html::a(
                                                        $item->lang->title,
                                                        Yii::$app->catalogFilter->createUrl($paramsUrl)
                                                    );
                                                }

                                                echo implode('; ', $array);
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($model->specificationValue != null) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Стиль') ?></td>
                                            <td>
                                                <?php
                                                $array = [];

                                                foreach ($model->specificationValue as $item) {
                                                    if ($item->specification->parent_id == 9) {
                                                        $paramsUrl = [];

                                                        if ($model->types) {
                                                            $paramsUrl[$keys['type']][] = $model->types->{Yii::$app->languages->getDomainAlias()};
                                                        }

                                                        $paramsUrl[$keys['style']][] = $item->specification->{Yii::$app->languages->getDomainAlias()};

                                                        $array[] = Html::a(
                                                            $item->specification->lang->title,
                                                            Yii::$app->catalogFilter->createUrl($paramsUrl)
                                                        );
                                                    }
                                                }

                                                echo implode('; ', $array) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($model->factory != null) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Factory') ?></td>
                                            <td>
                                                <?= Html::a(
                                                    $model->factory->title,
                                                    Factory::getUrl($model->factory->alias)
                                                ); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if (!empty($model->collection)) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Коллекция') ?></td>
                                            <td>
                                                <?= Html::a(
                                                    $model->collection->title ?? '',
                                                    Yii::$app->catalogFilter->createUrl(
                                                        Yii::$app->catalogFilter->params +
                                                        [$keys['factory'] => $model->factory->alias] +
                                                        [$keys['collection'] => $model->collection->id]
                                                    )
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <meta itemprop="sku" content="<?= $model->article ?>">

                                    <?php if (!$model->is_composition) { ?>
                                        <tr>
                                            <td><?= Yii::t('app', 'Артикул') ?></td>
                                            <td>
                                                <?= $model->article; ?>
                                            </td>
                                        </tr>

                                        <?php if (!empty($model->specificationValue)) { ?>
                                            <?php
                                            $array = [];
                                            foreach ($model->specificationValue as $item) {
                                                if ($item->specification->parent_id == 4 && $item->val) {
                                                    $str = '';
                                                    for ($n = 2; $n <= 10; $n++) {
                                                        $field = "val$n";
                                                        if ($item->{$field}) {
                                                            $str .= '; ' . $item->{$field};
                                                        }
                                                    }

                                                    $array[] = Html::beginTag('div') .
                                                        $item->specification->lang->title .
                                                        ' (' . Yii::t('app', 'см') . ')' .
                                                        ': ' .
                                                        $item->val . $str .
                                                        Html::endTag('div');
                                                }
                                            }
                                            if (!empty($array)) { ?>
                                                <tr>
                                                    <td><?= Yii::t('app', 'Размеры') ?></td>
                                                    <td>
                                                        <?= implode('', $array) ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                            <?php
                                            $array = [];
                                            foreach ($model->specificationValue as $item) {
                                                if ($item->specification->parent_id == 2) {
                                                    $array[] = $item->specification->lang->title;
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

                                <div class="prod-descr" itemprop="description"><?= $model->lang->description; ?></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-3">

                            <?php if (!$model->removed) { ?>
                                <div class="custom-image-gallery">
                                    <div class="igalery-close">
                                        <button class="btn-igalery-close">&times;</button>
                                    </div>
                                    <div class="igallery-images">
                                        <div class="scrollwrap">
                                        </div>
                                    </div>
                                    <div class="igallery-form scrolled">
                                        <div class="best-price-form">
                                            <?php if (!$detect->isMobile()) { ?>
                                                <h3><?= Yii::t('app', 'Заполните форму - получите лучшую цену на этот товар') ?></h3>
                                                <?= RequestPrice::widget(['product_id' => $model->id]) ?>
                                            <?php } ?>
                                        </div>
                                    </div>
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

                    <?php if (DOMAIN_TYPE == 'ru') {
                        echo $this->render('parts/_partners', [
                            'model' => $model
                        ]);
                    } ?>

                    <div class="best-price ecotime">
                        <div>
                            <div class="after-text">
                                <div class="img-container">
                                    <?= Html::img($bundle->baseUrl . '/img/hand.svg', ['width' => '290', 'height' => '60', 'loading' => 'lazy']) ?>
                                </div>
                                <div class="text-contain">
                                    <?= Yii::t('app', 'Экономьте время и усилия на поиск по множеству сайтов. Все лучшие и проверенные поставщики собраны в нашей сети.') ?>
                                    <div class="find-product-panel">
                                        <?= RequestFindProduct::widget(['view' => 'ajax_request_find_product']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($model->collections_id) {
                        echo $this->render('parts/_product_by_collection', [
                            'collection' => $model->collection,
                            'models' => Product::getProductByCollection($model->collections_id, $model->catalog_type_id)
                        ]);
                    } ?>

                    <?php if ($model->collections_id) {
                        echo $this->render('parts/_product_by_factory', [
                            'factory' => $model->factory,
                            'types' => $model->types,
                            'models' => Product::getProductByFactory($model->factory_id, $model->catalog_type_id)
                        ]);
                    } ?>

                    <?= ViewedProducts::widget([
                        'modelClass' => Product::class,
                        'modelLangClass' => ProductLang::class,
                        'cookieName' => 'viewed_products'
                    ]) ?>

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
$url2 = Url::to(['/shop/widget/ajax-request-price']);

if ($detect->isMobile()) {
    $script = <<<JS
var baseUrl = $("base").attr("href");
  function loadBestPriceForm() {
    if (window.screen.width <= 1024) {

        $(window).on('scroll', function (event) {

          var scrollBtnTop = $(window).scrollTop();
          var bestPriceForm = $('.best-price-form  #checkout-form');
          if (bestPriceForm.length == 0 && scrollBtnTop > 30) {

            var product_id = {$model->id},
            count = 1;

            if (event.cancelable) event.preventDefault();
            $.post(
                'shop/cart/add-to-cart/',
                {
                    _csrf: $('#token').val(),
                    id: product_id,
                    count: count,
                    flag: 'request-price'
                }
            ).done(function (data) {
                if (data == true) {
                    if (event.cancelable) event.preventDefault();
                    refresh_full_cart();

                    $.post(
                        baseUrl + 'shop/widget/ajax-request-price/',
                        {
                            _csrf: $('#token').val(),
                            product_id: product_id
                        }
                    ).done(function (data) {
                        if (data.success) {
                            $('.best-price-form').html(data.view);

                            var currentUrl = new URL(window.location.href);
                            if ( !(currentUrl.hostname.indexOf('.ru') != -1 || currentUrl.hostname.indexOf('.by') != -1 || currentUrl.hostname.indexOf('.ua') != -1) ) {
                              interPhoneInit('#cartcustomerform-phone');
                            }
                        }
                    });
                }
            });
            return true;
          }
        });
    }
  }
  loadBestPriceForm();
  $(window).resize(function () {
    loadBestPriceForm();
  });

JS;
    $this->registerJs($script);
}

$script = <<<JS
$.post('$url', {_csrf: $('#token').val(), product_id:{$model->id}}, function(data){
    $('.composition').html(data.html);
    $(".prod-card-page .nav-tabs li a").eq(0).click();
    // Выжидаем некоторое время
    setTimeout(function() {
        slickInit();
    }, 1000);
});

JS;

$this->registerJs($script);
