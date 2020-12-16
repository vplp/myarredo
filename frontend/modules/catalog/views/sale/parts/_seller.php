<?php

use yii\helpers\Html;
use frontend\modules\catalog\widgets\sale\SaleRequestForm;

?>
<div class="brand-info">
    <div class="white-area">
        <div class="image-container">
            <?= Html::img($bundle->baseUrl . '/img/brand.png') ?>
        </div>

        <div class="brand-info">
            <?php if ($model['user']['profile']['show_contacts_on_sale']) { ?>
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

                <?= Html::a(Yii::t('app', 'Узнать номер'), 'javascript:void(0);', [
                    'class' => 'js-show-num-btn'
                ]); ?>

                <div class="ico">
                    <?= Html::img($bundle->baseUrl . '/img/marker-map.png') ?>
                </div>
                <div class="text-center adress">
                    <?= $model['user']['profile']['city']['lang']['title']; ?>,<br>
                    <?= $model['user']['profile']['lang']['address']; ?>
                </div>

            <?php } else { ?>
                <h4 class="text-center">
                    <?= Yii::t('app', 'Распродажа') ?> My Arredo Family
                </h4>
                <p class="text-center">
                    <?= Yii::t('app', 'Для уточнения цены и наличия') ?>:
                </p>
            <?php } ?>

        </div>
    </div>
</div>
