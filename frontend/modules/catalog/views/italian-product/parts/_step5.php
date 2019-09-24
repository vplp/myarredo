<?php

use yii\helpers\{
    Html, Url
};
//
use yii\widgets\ActiveForm;
//
use frontend\modules\payment\models\Payment;
use frontend\modules\location\models\Currency;
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};
use frontend\modules\promotion\models\PromotionPackage;

/**
 * @var ItalianProduct $model
 * @var ItalianProductLang $modelLang
 */

$modelPromotionPackage = PromotionPackage::findBase()->all();
?>

<div class="form-horizontal add-itprod-content">

    <!-- steps box -->
    <div class="progress-steps-box">
        <div class="progress-steps-step<?= !Yii::$app->request->get('step') ? ' active' : '' ?>">
            <span class="step-numb">1</span>
            <span class="step-text"><?= Yii::t('app', 'Информация про товар') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'photo' ? ' active' : '' ?>">
            <span class="step-numb">2</span>
            <span class="step-text"><?= Yii::t('app', 'Фото товара') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'check' ? ' active' : '' ?>">
            <span class="step-numb">3</span>
            <span class="step-text"><?= Yii::t('app', 'Проверка товара') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'payment' ? ' active' : '' ?>">
            <span class="step-numb">4</span>
            <span class="step-text"><?= Yii::t('app', 'Оплата') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'promotion' ? ' active' : '' ?>">
            <span class="step-numb">5</span>
            <span class="step-text"><?= Yii::t('app', 'Больше просмотров') ?></span>
        </div>
    </div>
    <!-- steps box end -->

    <div class="page create-sale page-reclamations">
        <div class="largex-container">

            <div class="column-center">
                <div class="form-horizontal">

                    <?php foreach ($modelPromotionPackage as $model) { ?>
                        <div>
                            <?= $model['lang']['title'] ?>
                            <?= $model['price'] ?>€
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- rules box -->
<div class="add-itprod-rules">
    <div class="add-itprod-rules-item">

        <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_STEP4_TEXT') ?>

    </div>
</div>
<!-- rules box end -->

