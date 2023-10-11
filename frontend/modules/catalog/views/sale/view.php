<?php

use yii\helpers\{
    Html, Url
};
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{Factory, Sale, Product, SaleLang};
use frontend\modules\catalog\widgets\sale\{
    SaleRequestForm, SaleOfferPriceForm
};
use frontend\modules\catalog\widgets\product\ViewedProducts;
use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);
/**
 * @var $model Sale
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
                    <div class="row sale-prod" itemscope itemtype="http://schema.org/Product">
                        <div class="col-sm-6 col-md-6 col-lg-5">

                            <?= $this->render('parts/_carousel', [
                                'model' => $model
                            ]) ?>

                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <?php if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin'])) {
                                echo Html::a(
                                    Yii::t('app', 'Edit'),
                                    '/backend/catalog/sale/update?id=' . $model['id'],
                                    ['target' => '_blank']
                                );
                            } ?>
                            <div class="prod-info" itemprop="offers" itemscope
                                 itemtype="http://schema.org/Offer">
                                <?= Html::tag('h1', $model->getTitle()); ?>

                                <?php if (Sale::getSavingPrice($model) > 0 && $model->is_sold == '0') { ?>
                                    <div class="old-price">
                                        <?= Yii::$app->currency->getValue($model['price'], $model['currency']) . ' ' . Yii::$app->currency->symbol; ?>
                                    </div>
                                <?php } ?>

                                <div class="prod-price">
                                    <div class="price">
                                        <?= Yii::t('app', 'Цена') ?>:
                                        <span>
                                        <?= Yii::$app->currency->getValue($model['price_new'], $model['currency']) . ' ' . Yii::$app->currency->symbol; ?>
                                            <meta itemprop="price" content="<?= $model->price_new ?>">
                                            <meta itemprop="priceCurrency" content="<?= $model->currency ?>"/>
                                            <meta itemprop="availability" content="InStock"/>
                                            <meta itemprop="priceValidUntil" content="<?= date('Y-m-d') ?>"/>
                                            <link itemprop="url" href="<?= Sale::getUrl($model['alias']) ?>"/>
                                    </span>
                                    </div>
                                    <?php if (Sale::getSavingPrice($model) > 0 && !$model->is_sold) { ?>
                                        <div class="price economy">
                                            <?= Yii::t('app', 'Экономия') ?>:
                                            <span><?= Yii::$app->currency->getValue(Sale::getSavingPrice($model), $model['currency']) . ' ' . Yii::$app->currency->symbol; ?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php if ($model->is_sold) { ?>
                                <div class="prod-is-sold"><?= Yii::t('app', 'Item sold') ?></div>
                            <?php } ?>

                            <?= Html::a(Yii::t('app', 'Хочу купить'), 'javascript:void(0);', [
                                'class' => 'write-seller',
                                'data-toggle' => 'modal',
                                'data-target' => '#modalSaleRequestForm'
                            ]);?>

                            <?= SaleRequestForm::widget(['sale_item_id' => $model['id']]) ?>

                            <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                <meta itemprop="ratingValue" content="5"/>
                                <meta itemprop="bestRating" content="5"/>
                                <meta itemprop="ratingCount" content="1"/>
                                <meta itemprop="reviewCount" content="1"/>
                            </div>
                            <div itemprop="review" itemscope itemtype="http://schema.org/Review">
                                <div itemprop="author" itemtype="https://schema.org/Person" itemscope>
                                    <meta itemprop="name" content="user" />
                                </div>
                            </div>

                            <meta itemprop="sku" content="<?= $model['article'] ?>">
                            <meta itemprop="name" content="<?= $model->getTitle() ?>">

                            <table class="info-table" width="100%">
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
                                        <div itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
                                        <?= ($model['catalogFactory'])
                                            ? Html::a(
                                                Html::tag('span', $model['catalogFactory']['title'], ['itemprop' => 'brand']),
                                                Factory::getUrl($model['catalogFactory']['alias'])
                                            )
                                            : $model['factory']['title'] ?? ''; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php if (!empty($model['specificationValue'])) {
                                    $array = [];
                                    foreach ($model['specificationValue'] as $item) {
                                        if ($item['specification']['parent_id'] == 9) {
                                            $keys = Yii::$app->catalogFilter->keys;
                                            $params = Yii::$app->catalogFilter->params;
                                            $params[$keys['style']] = $item['specification'][Yii::$app->languages->getDomainAlias()];

                                            ($model['catalogFactory']) ? $params[$keys['factory']] = $model['catalogFactory']['alias'] : null;

                                            $array[] = [
                                                'title' => $item['specification']['lang']['title'],
                                                'url' => Yii::$app->catalogFilter->createUrl($params, ['/catalog/sale/list'])
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
                                                    echo Html::beginTag('div') .
                                                        $item['specification']['lang']['title'] .
                                                        ' (' . Yii::t('app', 'см') . ')' .
                                                        ': ' .
                                                        $item['val'] .
                                                        Html::endTag('div');
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
                            </table>

                            <?= Html::a(
                                Yii::t('app', 'Предложите свою цену'),
                                'javascript:void(0);',
                                [
                                    'class' => 'btn btn-offerprice',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalSaleOfferPrice'
                                ]
                            ) ?>

                            <div class="prod-shortstory" itemprop="description">
                                <?= $model['lang']['description']; ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 sellout-cont">

                            <?php if (!empty($model['user'])) {
                                echo $this->render('parts/_seller', [
                                    'model' => $model,
                                    'bundle' => $bundle,
                                    'vote' => $vote
                                ]);
                            } ?>

                        </div>

                        <?php /*
                        <div class="col-md-12 sellout-box">
                            <div class="section-header">
                                <h2><?= Yii::t('app', 'Распродажа итальянской мебели') ?></h2>
                                <?= Html::a(
                            Yii::t('app', 'Вернуться к списку'),
                            Url::toRoute(['/catalog/sale/list']),
                            ['class' => 'back']
                        ); ?>
                            </div>
                        </div>
                        */ ?>

                    </div>

                    <div class="row">
                        <?= $this->render('parts/_reviews', [
                            'model' => $model,
                            'reviews' => $reviews
                        ]) ?>
                    </div>

                    <?= $this->render('@app/modules/catalog/views/product/parts/_product_by_factory', [
                        'factory' => $model['factory'],
                        'types' => $model['types'],
                        'models' => Product::getProductByFactory($model['factory_id'], $model['catalog_type_id'])
                    ]) ?>

                    <?= ViewedProducts::widget([
                        'modelClass' => Sale::class,
                        'modelLangClass' => SaleLang::class,
                        'cookieName' => 'viewed_sale'
                    ]) ?>

                </div>
            </div>
        </div>
    </main>

<?= SaleOfferPriceForm::widget(['sale_item_id' => $model['id']]) ?>


<?php
$user_id = $model['user']['id'];
$sale_item_id = $model['id'];
$url = Url::toRoute(['//catalog/sale/ajax-get-phone']);
$phone = $model['phone'] ?? null;

if (!empty($phone)) {
    $script = <<<JS
    let phone = '$phone';
    $('.js-show-num-btn').on('click', function () {
        $('.js-show-num').html('<a href="tel:'+phone+'">'+phone+'</a>');
        $('.js-show-num-btn').remove();
    });
JS;
} else {
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
}

$this->registerJs($script);
