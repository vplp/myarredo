<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\{
    Factory, Sale
};

/**
 * @var \frontend\modules\catalog\models\Sale $model
 */

?>

<main>
    <div class="page sale-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex s-between c-align top-links">

                        <?php if ($model['factory']): ?>
                            <?= Html::a(
                                $model['factory']['lang']['title'],
                                Factory::getUrl($model['factory']['alias']),
                                ['class' => 'brand']
                            ); ?>
                        <?php endif; ?>

                        <?= Html::a(
                            'Вернуться к списку',
                            Url::toRoute(['/catalog/sale/list']),
                            ['class' => 'back']
                        ); ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h1><?= $model->getTitle() ?></h1>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5">
                    <div class="img-wrap">
                        <a href="javascript:void(0);" class="img-cont">
                            <?= Html::img(Sale::getImageThumb($model['image_link'])); ?>
                        </a>
                        <a href="javascript:void(0);" class="zoom">
                            Увеличить
                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7">
                    <div class="prod-info">

                        <div class="prod-style">
                            <span>Стиль: </span>
                            <?php
                            $array = [];
                            foreach ($model['specificationValue'] as $item): ?>
                                <?php if ($item['specification']['parent_id'] == 9): ?>
                                    <?php $array[] = $item['specification']['lang']['title']; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?= implode('; ', $array); ?>
                        </div>
                        <div class="prod-price">
                            <div class="price">
                                <?= $model->price_new ?> <?= $model->currency ?>
                            </div>

                            <?php if ($model->price > 0): ?>
                                <div class="old-price">
                                    (старая цена - <b><?= $model->price ?>  <?= $model->currency ?></b>)
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="prod-shortstory">
                            <?= $model['lang']['description']; ?>
                        </div>
                        <table class="infotable" width="100%">
                            <tr>
                                <td>
                                    Размеры

                                    <?php foreach ($model['specificationValue'] as $item): ?>
                                        <?php if ($item['specification']['parent_id'] == 4): ?>

                                            <?= $item['specification']['alias']; ?>:<?= $item['val']; ?>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td>
                                    Материал

                                    <?php
                                    $array = [];
                                    foreach ($model['specificationValue'] as $item): ?>
                                        <?php if ($item['specification']['parent_id'] == 2): ?>
                                            <?php $array[] = $item['specification']['lang']['title']; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <?= implode('; ', $array); ?>
                                </td>
                            </tr>
                        </table>

                        <?php if (!empty($model['user'])) { ?>

                            <div class="seller-cont">
                                <h4>Контакты продавца</h4>
                                <div class="title"><?= $model['user']['profile']['name_company']; ?></div>
                                <a href="tel:+380442309379">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    <?= $model['user']['profile']['phone']; ?>
                                </a>
                                <div class="location">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <?= $model['user']['profile']['address']; ?>
                                </div>
                                <a href="mailto:<?= $model['user']['email']; ?>">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    <?= $model['user']['email']; ?>
                                </a>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>