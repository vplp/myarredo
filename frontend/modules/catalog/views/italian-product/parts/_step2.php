<?php

use yii\helpers\{
    Html, Url
};
//
use backend\app\bootstrap\ActiveForm;

/**
 * @var \frontend\modules\catalog\models\ItalianProduct $model
 * @var \frontend\modules\catalog\models\ItalianProductLang $modelLang
 */

?>

<?php $form = ActiveForm::begin([
    //'action' => Url::toRoute(['/catalog/italian-product/update', 'id' => $model->id,]),
    'fieldConfig' => [
        'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
        'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
    ],
]); ?>

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
