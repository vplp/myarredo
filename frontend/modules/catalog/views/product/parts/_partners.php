<?php

use frontend\modules\user\models\User;
use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{Factory, Product, ProductLang};

/**
 * @var $model Product
 */


$partners = User::getPartners(Yii::$app->city->getCityId());
$images = $model->getGalleryImageThumb();

?>

<div class="salonesbox">
    <div class="section-header">
        <h3 class="section-title">
            <?= Yii::t('app', 'Салоны продаж') ?>
        </h3>
    </div>
    <div class="salones-body">
        <div class="row">
            <div class="col-sm-6 col-lg-5">
                <div class="salones-list">
                    <table class="info-table table-salones-list">
                        <tbody>

                        <?php foreach ($partners as $partner) {
                            if ($partner->profile->lang->address) { ?>
                                <tr>
                                    <td><?= $partner->profile->getNameCompany() ?></td>
                                    <td><?= $partner->profile->city->getTitle() . ', ' . $partner->profile->lang->address ?? '' ?></td>
                                </tr>
                            <?php }
                        } ?>

                        </tbody>
                    </table>
                    <div class="gradient-bg"></div>
                </div>
                <div class="allsalones-panel">
                    <?= Html::a(
                        Yii::t('app', 'View all sales offices'),
                        Url::toRoute('/page/contacts/list-partners'),
                        ['class' => 'all-salones-link']
                    ); ?>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <?php if ($model['price_from']) { ?>
                    <div class="last-sale">
                        <div class="last-sale-top">

                            <h4 class="last-sale-title"><?= $model->getTitle() ?></h4>
                            <div class="last-sale-info">
                                <div class="last-sale-left">
                                    <?= Html::img($images[0]['thumb'], ['alt' => Product::getImageAlt($model), 'class' => 'last-sale-img']) ?>
                                </div>
                                <div class="last-sale-right">
                                    <div class="last-sale-tablebox">
                                        <table class="last-sale-table">
                                            <?php if (!empty($model['specificationValue'])) { ?>
                                                <?php
                                                $array = [];
                                                foreach ($model['specificationValue'] as $item) {
                                                    if ($item['specification']['parent_id'] == 4 && $item['val']) {
                                                        $str = '';
                                                        for ($n = 2; $n <= 10; $n++) {
                                                            $field = "val$n";
                                                            if ($item[$field]) {
                                                                $str .= '; ' . $item[$field];
                                                            }
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?= $item['specification']['lang']['title'] . ' (' . Yii::t('app', 'см') . ')' ?></td>
                                                            <td>
                                                                <?= $item['val'] . $str ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>

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
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="last-sale-bottom">
                            <div class="last-sale-infobot">
                                <div class="last-sale-left">
                                    <div class="last-sale-text top">
                                        <?= Yii::t('app', 'Последний раз этот товар был продан партнером нашей сети за') ?>
                                        :
                                    </div>
                                    <div class="last-sale-text">
                                    <span class="for-lastsale-curval">
                                        <?php
                                        $price = Yii::$app->currency->getReversValue($model['price_from'], Yii::$app->currency->code, 'EUR');
                                        echo Yii::$app->currency->getValue($price * 60, 'EUR');
                                        ?>
                                    </span>
                                        <span class="for-lastsale-curency"><?= Yii::$app->currency->symbol ?></span>
                                    </div>
                                </div>
                                <div class="last-sale-right">
                                    <div class="last-sale-arrow">
                                        <div class="arrow-block"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
