<?php

use yii\helpers\Html;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    Factory, Product
};
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\shop\widgets\request\RequestPrice;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

$bundle = AppAsset::register($this);

$products_id = [];
foreach (Yii::$app->shop_cart->items as $item) {
    $products_id[] = $item->product_id;
}

$elementsComposition = $model['elementsComposition'];

$keys = Yii::$app->catalogFilter->keys;

$this->title = $this->context->title;

?>

<main>
    <div class="prod-card-page page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="row" itemscope itemtype="http://schema.org/Product">

                    <?php if (!isset($this->context->factory)) { ?>
                        <?= Breadcrumbs::widget([
                            'links' => $this->context->breadcrumbs,
                        ]) ?>
                    <?php } ?>

                    <div class="col-sm-6 col-md-6 col-lg-5">

                        <?= $this->render('parts/_carousel', [
                            'model' => $model
                        ]); ?>

                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4">
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

                                <?php if (!$model['removed'] && $model['price_from'] > 0) { ?>
                                    <div class="price-sticker">
                                        <?= Yii::t('app', 'Цена от') ?>:
                                        <span>
                                        <?= $model['price_from']; ?>&nbsp;<span class="currency">€</span>
                                            <meta itemprop="price"
                                                  content="<?= number_format($model['price_from'], 0, '', '') ?>">
                                            <meta itemprop="priceCurrency" content="EUR"/>
                                    </span>
                                    </div>
                                <?php } else { ?>
                                    <meta itemprop="price" content="0"/>
                                    <meta itemprop="priceCurrency" content="EUR"/>
                                <?php } ?>

                                <div class="availability">
                                    <?= Yii::t('app', 'Наличие') ?>:
                                    <span><?= ($model['status']) ?></span>
                                    <?php if (!$model['removed'] && $model['in_stock']) { ?>
                                        <meta itemprop="availability" content="InStock">
                                    <?php } elseif (!$model['removed']) { ?>
                                        <meta itemprop="availability" content="PreOrder">
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="alert" role="alert">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <?= Yii::t('app', 'Окончательная цена согласовывается с продавцом.') ?>
                            </div>


                            <?php if (!Yii::$app->getUser()->isGuest && $model['factory']['new_price']) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                    <?= Yii::t('app', 'Цена требует проверки, есть новый прайс') ?>
                                </div>
                            <?php } ?>

                            <table class="info-table">
                                <tr>
                                    <td><?= Yii::t('app', 'Стиль') ?></td>
                                    <td>
                                        <?php
                                        $array = [];
                                        foreach ($model['specificationValue'] as $item) {
                                            if ($item['specification']['parent_id'] == 9) {
                                                $array[] = $item['specification']['lang']['title'];
                                            }
                                        }

                                        echo implode('; ', $array);
                                        ?>
                                    </td>
                                </tr>

                                <?php if ($model['factory'] != null) { ?>
                                    <tr>
                                        <td><?= Yii::t('app', 'Factory') ?></td>
                                        <td>
                                            <meta itemprop="brand" content="<?= $model['factory']['title'] ?>">
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
                                                $model['collection']['title'],
                                                Yii::$app->catalogFilter->createUrl(
                                                    Yii::$app->catalogFilter->params +
                                                    [$keys['factory'] => $model['factory']['alias']] +
                                                    [$keys['collection'] => $model['collection']['id']]
                                                )
                                            ); ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if (!$model['is_composition']) { ?>
                                    <tr>
                                        <td><?= Yii::t('app', 'Артикул') ?></td>
                                        <td><?= $model['article']; ?></td>
                                    </tr>

                                    <?php if (!empty($model['specificationValue'])) { ?>
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
                                        <tr>
                                            <td><?= Yii::t('app', 'Материал') ?></td>
                                            <td>
                                                <?php
                                                $array = [];
                                                foreach ($model['specificationValue'] as $item) {
                                                    if ($item['specification']['parent_id'] == 2) {
                                                        $array[] = $item['specification']['lang']['title'];
                                                    }
                                                }
                                                echo implode('; ', $array);
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                            </table>

                            <?= $this->render('parts/_factory_files', [
                                'model' => $model
                            ]); ?>

                            <div class="prod-descr" itemprop="description"><?= $model['lang']['description']; ?></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-3">

                        <?php if (!$model['removed']) { ?>
                            <div class="best-price-form">

                                <h3><?= Yii::t('app', 'Заполните форму - получите лучшую цену на этот товар') ?></h3>

                                <?= RequestPrice::widget(['product_id' => $model['id']]) ?>

                                <?php
                                if (!in_array(Yii::$app->controller->action->id, ['product'])) {
                                    if (!in_array($model['id'], $products_id)) {
                                        echo Html::a(
                                            Yii::t('app', 'Отложить в блокнот'),
                                            'javascript:void(0);',
                                            [
                                                'class' => 'add-to-notepad btn btn-default big',
                                                'data-id' => $model['id'],
                                                'data-toggle' => 'modal',
                                                'data-target' => '#myModal'
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

                        <?php } else { ?>
                            <?= Yii::t(
                                'app',
                                'Данный товар снят с протзводства. Но мы можем предложить альтернативную модель.'
                            ) ?>
                        <?php } ?>

                    </div>
                </div>


                <div class="best-price">
                    <div class="container large-container">
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
                                        <img src="<?= $bundle->baseUrl ?>/img/num1.svg" alt="">
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
                                        <img src="<?= $bundle->baseUrl ?>/img/num2.svg" alt="">
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
                                        <img src="<?= $bundle->baseUrl ?>/img/num3.svg" alt="">
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
                                        <img src="<?= $bundle->baseUrl ?>/img/num4.svg" alt="">
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
                                        <img src="<?= $bundle->baseUrl ?>/img/num5.svg" alt="">
                                    </div>
                                </div>
                                <div class="descr">
                                    <?= Yii::t('app', 'В сети MY ARREDO FAMILY только проверенные поставщики, которые подтвердили свою надежность.') ?>
                                </div>
                            </div>
                        </div>
                        <div class="after-text">
                            <div class="img-container">
                                <img src="<?= $bundle->baseUrl ?>/img/hand.svg" alt="">
                            </div>
                            <div class="text-contain">
                                <?= Yii::t('app', 'Экономьте время и усилия на поиск по множеству сайтов. Все лучшие и проверенные поставщики собраны в нашей сети.') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row composition">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <?php if (!empty($elementsComposition)) { ?>
                                <li>
                                    <a data-toggle="tab" href="#panel1"><?= Yii::t('app', 'Предметы композиции') ?></a>
                                </li>
                            <?php } ?>
                            <?php if (!empty($model['samples'])) { ?>
                                <li>
                                    <a data-toggle="tab" href="#panel2"><?= Yii::t('app', 'Варианты отделки') ?></a>
                                </li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">

                            <?php if (!empty($elementsComposition)) { ?>
                                <div id="panel1" class="tab-pane fade">
                                    <?= $this->render('parts/_product_by_composition', [
                                        'models' => $elementsComposition
                                    ]); ?>
                                </div>
                            <?php } ?>

                            <?php if (!empty($model['samples'])) { ?>
                                <div id="panel2" class="tab-pane fade">
                                    <?= $this->render('parts/_samples', [
                                        'samples' => $model['samples']
                                    ]); ?>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <?php /*if (!$model['removed']): ?>

                <div class="recommendation">
                    <div class="container large-container">
                        <h3 class="offer_title">Выберите любой понравившийся товар и получите на него лучшую цену!</h3>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/prod_thumb1.png" alt="">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="feedback-flex flex s-around">
                                    <div class="metr">Меня заинтересовал товар</div>
                                    <form role="form" class="flex-form">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="product"
                                                   value="Буфет Momenti Arte 0114" readonly>
                                        </div>
                                        <h4>Мои контактные данные:*</h4>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Имя">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="E-mail">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="+7 (___) ___-__-__">
                                        </div>
                                        <button type="submit" class="btn btn-success">Жду лучшую цену</button>
                                    </form>
                                </div>
                                <div class="aft-text">Портал MyArredo гарантирует конфиденциальность личной информации
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; */ ?>

                <?php
                if ($model['collections_id']) {
                    echo $this->render('parts/_product_by_collection', [
                        'collection' => $model['collection'],
                        'models' => $model->getProductByCollection($model['collections_id'], $model['catalog_type_id'])
                    ]);
                } ?>

                <?php
                if ($model['collections_id']) {
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
