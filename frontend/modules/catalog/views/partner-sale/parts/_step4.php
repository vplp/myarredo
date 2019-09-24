<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\{
    Sale, SaleLang
};
use frontend\modules\promotion\models\PromotionPackage;

/**
 * @var $model Sale
 * @var $modelLang SaleLang
 */
$modelPromotionPackage = PromotionPackage::findBase()->all();
?>

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
    <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'promotion' ? ' active' : '' ?>">
        <span class="step-numb">4</span>
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