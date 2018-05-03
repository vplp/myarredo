<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\{
    Factory, Sale
};
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
                            <?php
                            $array = [];
                            foreach ($model['specificationValue'] as $item) {
                                if ($item['specification']['parent_id'] == 9) {
                                    $array[] = $item['specification']['lang']['title'];
                                }
                            }
                            ?>

                            <?php if ($model->price > 0): ?>
                                <div class="old-price">
                                    <?= $model->price . ' ' . $model->currency; ?>
                                </div>
                            <?php endif; ?>

                            <div class="prod-price">
                                <div class="price">
                                    <?= Yii::t('app', 'Цена') ?>:
                                    <span>
                                        <?= $model->price_new . ' ' . $model->currency; ?>
                                    </span>
                                </div>
                                <div class="price economy">
                                    <?= Yii::t('app', 'Экономия') ?>:
                                    <span>
                                        <?= ($model->price - $model->price_new) . ' ' . $model->currency; ?>
                                    </span>
                                </div>
                            </div>

                            <?php if (!empty($array)) { ?>
                                <div class="prod-style">
                                    <span><?= Yii::t('app', 'Стиль') ?> : </span>
                                    <?= implode('; ', $array) ?>
                                </div>
                            <?php }
                            ?>

                        </div>

                        <table class="infotable" width="100%">
                            <?php if (!empty($model['specificationValue'])): ?>
                                <tr>
                                    <td><?= Yii::t('app', 'Размеры') ?></td>
                                    <td>
                                        <div class="size-group">
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
                                        </div>
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
                            <?php endif; ?>
                        </table>

                        <div class="prod-shortstory">
                            <?= $model['lang']['description']; ?>
                        </div>

                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

                        <?php /*if (!empty($model['user'])) { ?>

                            <div class="brand-info">
                                <div class="white-area">
                                    <div class="image-container">
                                        <img src="<?= $bundle->baseUrl ?>/img/brand.png" alt="">
                                    </div>
                                    <div class="brand-info">
                                        <p class="text-center">
                                            <?= Yii::t('app', 'Контакты продавца') ?>
                                        </p>
                                        <h4 class="text-center"><?= $model['user']['profile']['name_company']; ?></h4>
                                        <div class="ico">
                                            <img src="<?= $bundle->baseUrl ?>/img/phone.svg" alt="">
                                        </div>
                                        <div class="tel-num js-show-num"
                                             data-num="<?= $model['user']['profile']['phone']; ?>">
                                            +7 (8<span>ХХ</span>) <span>ХХХ ХХ ХХ</span>
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
                                        <a href="javascript:void(0);" class="write-seller">
                                            написать продавцу
                                        </a>
                                    </div>
                                </div>
                            </div>

                      <?php }*/ ?>

                    </div>

                </div>

                <?php /*
                <div class="row similar-prod-wrap">
                    <div class="col-md-12">
                        <div class="similar-prod">
                            <h3>похожие объявления</h3>
                            <div class="similar-prod-grid">
                                <a href="#" class="item" data-dominant-color>
                                    <div class="img-cont">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/rec2.png" alt="">
                                        <span class="background"></span>
                                    </div>
                                    <div class="add-item-text">
                                        Кресло CREAZIONI (BY
                                        SILIK) La fantasia e mobile...
                                    </div>
                                </a>
                                <a href="#" class="item" data-dominant-color>
                                    <div class="img-cont">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/rec1.jpg" alt="">
                                        <span class="background"></span>
                                    </div>
                                    <div class="add-item-text">
                                        Кресло CREAZIONI (BY
                                        SILIK) La fantasia e mobile...
                                    </div>
                                </a>
                                <a href="#" class="item" data-dominant-color>
                                    <div class="img-cont">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/rec2.png" alt="">
                                        <span class="background"></span>
                                    </div>
                                    <div class="add-item-text">
                                        Кресло CREAZIONI (BY
                                        SILIK) La fantasia e mobile...
                                    </div>
                                </a>
                                <a href="#" class="item" data-dominant-color>
                                    <div class="img-cont">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/rec1.jpg" alt="">
                                        <span class="background"></span>
                                    </div>
                                    <div class="add-item-text">
                                        Кресло CREAZIONI (BY
                                        SILIK) La fantasia e mobile...
                                    </div>
                                </a>
                                <a href="#" class="item" data-dominant-color>
                                    <div class="img-cont">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/rec1.jpg" alt="">
                                        <span class="background"></span>
                                    </div>
                                    <div class="add-item-text">
                                        Кресло CREAZIONI (BY
                                        SILIK) La fantasia e mobile...
                                    </div>
                                </a>
                                <a href="#" class="item" data-dominant-color>
                                    <div class="img-cont">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/rec2.png" alt="">
                                        <span class="background"></span>
                                    </div>
                                    <div class="add-item-text">
                                        Кресло CREAZIONI (BY
                                        SILIK) La fantasia e mobile...
                                    </div>
                                </a>
                                <a href="#" class="item" data-dominant-color>
                                    <div class="img-cont">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/rec1.jpg" alt="">
                                        <span class="background"></span>
                                    </div>
                                    <div class="add-item-text">
                                        Кресло CREAZIONI (BY
                                        SILIK) La fantasia e mobile...
                                    </div>
                                </a>
                            </div>
                            <a href="javascript:void(0);" class="more-posts">
                                Еще объявления
                            </a>
                        </div>
                    </div>
                </div>

                */ ?>
                
            </div>
        </div>
    </div>
</main>