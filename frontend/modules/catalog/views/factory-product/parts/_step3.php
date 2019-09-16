<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\{
    FactoryProduct, FactoryProductLang
};
use yii\helpers\Url;

/**
 * @var FactoryProduct $model
 * @var FactoryProductLang $modelLang
 */

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
</div>
<!-- steps box end -->

    <?= $this->render('../../product/view', [
        'model' => $model,
        'modelLang' => $modelLang
    ]) ?>

    <div class="buttons-cont">
        <?= Html::a(
            Yii::t('app', 'Edit'),
            ['/catalog/factory-product/update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>

        <?= Html::a(
            Yii::t('app', 'Опубликовать'),
            ['/catalog/factory-promotion/create', 'product_id' => $model->id],
            ['class' => 'btn btn-goods']
        ) ?>
    </div>

</div>

<!-- rules box -->
<div class="add-itprod-rules">
    <div class="add-itprod-rules-item">

        <?= Yii::$app->param->getByName('PARTNER_SALE_TEXT') ?>

    </div>
</div>
<!-- rules box end -->

<?php
$script = <<<JS
$('.best-price-form').parent().hide();
$('.best-price').hide();
$('.rec-slider-wrap').hide();
JS;

$this->registerJs($script);
