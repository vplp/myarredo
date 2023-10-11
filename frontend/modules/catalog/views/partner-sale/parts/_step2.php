<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    Sale, SaleLang
};
use backend\app\bootstrap\ActiveForm;

/**
 * @var $model Sale
 * @var $modelLang SaleLang
 */

?>

<div class="form-horizontal add-itprod-content">

    <!-- steps box -->

    <?= $this->render('_steps_box') ?>

    <!-- steps box end -->

    <?php $form = ActiveForm::begin([
        'id' => 'step2',
        'fieldConfig' => [
            'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
            'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
        ]
    ]) ?>

    <?= $form
        ->field($model, 'image_link')
        ->imageOne($model->getImageLink()) ?>

    <?= $form
        ->field($model, 'gallery_image')
        ->imageSeveral(['initialPreview' => $model->getGalleryImage()]) ?>

    <div class="buttons-cont">
        <?= Html::submitButton(
            Yii::t('app', 'Save'),
            ['class' => 'btn btn-success']
        ) ?>

        <?= Html::a(
            Yii::t('app', 'Cancel'),
            ['/catalog/partner-sale/list'],
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
