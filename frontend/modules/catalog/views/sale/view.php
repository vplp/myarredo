<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    Factory, Sale, Product
};
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
                            ]); ?>

                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'admin') {
                                echo Html::a(
                                    Yii::t('app', 'Edit'),
                                    '/backend/catalog/sale/update?id=' . $model['id'],
                                    [
                                        'target' => '_blank'
                                    ]
                                );
                            } ?>
                            <div class="prod-info" itemprop="offers" itemscope
                                 itemtype="http://schema.org/Offer">
                                <?= Html::tag('h1', $model->getTitle()); ?>

                                <?php if ($model->getSavingPrice() > 0) { ?>
                                    <div class="old-price">
                                        <?= $model->price . ' ' . $model->currency; ?>
                                    </div>
                                <?php } ?>

                                <div class="prod-price">
                                    <div class="price">
                                        <?= Yii::t('app', 'Цена') ?>:
                                        <span>
                                        <?= $model->price_new . ' ' . $model->currency; ?>
                                            <meta itemprop="price" content="<?= $model->price_new ?>">
                                            <meta itemprop="priceCurrency" content="<?= $model->currency ?>"/>
                                            <meta itemprop="availability" content="InStock"/>
                                            <meta itemprop="priceValidUntil" content="<?= date('Y-m-d') ?>"/>
                                            <meta itemprop="url" content="<?= Sale::getUrl($model['alias']) ?>"/>
                                    </span>
                                    </div>
                                    <?php if ($model->getSavingPrice() > 0) { ?>
                                        <div class="price economy">
                                            <?= Yii::t('app', 'Экономия') ?>:
                                            <span>
                                            <?= $model->getSavingPrice() . ' ' . $model->currency; ?>
                                        </span>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <?= Html::a(
                                Yii::t('app', 'Предложите свою цену'),
                                'javascript:void(0);',
                                [
                                    'class' => 'btn btn-offerprice',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalSaleOfferPrice'
                                ]
                            ) ?>

                            <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                <meta itemprop="ratingValue" content="5"/>
                                <meta itemprop="bestRating" content="5"/>
                                <meta itemprop="ratingCount" content="1"/>
                                <meta itemprop="reviewCount" content="1"/>
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
                                        <?= ($model['factory'])
                                            ? Html::a(
                                                $model['factory']['title'],
                                                Factory::getUrl($model['factory']['alias'])
                                            ) : $model['factory_name']; ?>
                                        <meta itemprop="brand"
                                              content="<?= ($model['factory']) ? $model['factory']['title'] : $model['factory_name']; ?>"/>
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

                            <div class="prod-shortstory" itemprop="description">
                                <?= $model['lang']['description']; ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 sellout-cont">

                            <?php if (!empty($model['user'])) { ?>
                                <div class="brand-info">
                                    <div class="white-area">
                                        <div class="image-container">
                                            <?= Html::img($bundle->baseUrl . '/img/brand.png') ?>
                                        </div>
                                        <div class="brand-info">
                                            <p class="text-center">
                                                <?= Yii::t('app', 'Контакты продавца') ?>
                                            </p>
                                            <h4 class="text-center">
                                                <?= $model['user']['profile']['lang']['name_company']; ?>
                                            </h4>
                                            <div class="ico">
                                                <?= Html::img($bundle->baseUrl . '/img/phone.svg') ?>
                                            </div>
                                            <div class="tel-num js-show-num">
                                                (XXX) XXX-XX-XX
                                            </div>

                                            <?= Html::a(
                                                Yii::t('app', 'Узнать номер'),
                                                'javascript:void(0);',
                                                ['class' => 'js-show-num-btn']
                                            ) ?>

                                            <div class="ico">
                                                <?= Html::img($bundle->baseUrl . '/img/marker-map.png') ?>
                                            </div>
                                            <div class="text-center adress">
                                                <?= $model['user']['profile']['city']['lang']['title']; ?>,<br>
                                                <?= $model['user']['profile']['lang']['address']; ?>
                                            </div>

                                            <div class="ico">
                                                <?= Html::img($bundle->baseUrl . '/img/conv.svg') ?>
                                            </div>

                                            <?= Html::a(
                                                Yii::t('app', 'Написать продавцу'),
                                                'javascript:void(0);',
                                                [
                                                    'class' => 'write-seller',
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#modalSaleRequestForm'
                                                ]
                                            ) ?>

                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>

                        <!--
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
                        -->

                    </div>

                    <?= $this->render('@app/modules/catalog/views/product/parts/_product_by_factory', [
                        'factory' => $model['factory'],
                        'types' => $model['types'],
                        'models' => Product::getProductByFactory($model['factory_id'], $model['catalog_type_id'])
                    ]) ?>

                    <?= ViewedProducts::widget(['modelClass' => Sale::class, 'cookieName' => 'viewed_sale']) ?>

                </div>
            </div>
        </div>
    </main>

<?= SaleRequestForm::widget(['sale_item_id' => $model['id']]) ?>
<?= SaleOfferPriceForm::widget(['sale_item_id' => $model['id']]) ?>


<?php
$user_id = $model['user']['id'];
$sale_item_id = $model['id'];
$url = Url::toRoute(['//catalog/sale/ajax-get-phone']);
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