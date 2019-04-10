<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};
//
use backend\app\bootstrap\ActiveForm;

/**
 * @var ItalianProduct $model
 * @var ItalianProductLang $modelLang
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
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'payment' ? ' active' : '' ?>">
            <span class="step-numb">4</span>
            <span class="step-text"><?= Yii::t('app', 'Оплата') ?></span>
        </div>
    </div>
    <!-- steps box end -->

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
            'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
        ],
    ]) ?>

    <?= $form
        ->field($model, 'image_link')
        ->imageOne($model->getImageLink()) ?>

    <?= $form
        ->field($model, 'gallery_image')
        ->imageSeveral(['initialPreview' => $model->getGalleryImage()]) ?>

    <?= $form->field($model, 'file_link')->fileInputWidget(
        $model->getFileLink(),
        ['accept' => '.jpeg,.png,.doc,.docx,.xlsx,application/pdf', 'maxFileSize' => 0],
        ['jpeg', 'png', 'pdf', 'doc', 'docx', 'xlsx']
    ) ?>

    <div class="buttons-cont">
        <?= Html::submitButton(
            Yii::t('app', 'Save'),
            ['class' => 'btn btn-success']
        ) ?>

        <?= Html::a(
            Yii::t('app', 'Cancel'),
            ['/catalog/italian-product/list'],
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!-- rules box -->
<div class="add-itprod-rules">
    <div class="add-itprod-rules-item">

        <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_STEP2_TEXT') ?>

    </div>
</div>
<!-- rules box end -->


