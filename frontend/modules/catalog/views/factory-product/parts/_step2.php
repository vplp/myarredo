<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\{
    FactoryProduct, FactoryProductLang
};
//
use backend\app\bootstrap\ActiveForm;

/**
 * @var FactoryProduct $model
 * @var FactoryProductLang $modelLang
 */

?>

<div class="form-horizontal add-itprod-content">

    <!-- steps box -->

    <?= $this->render('_steps_box') ?>

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

    <div class="buttons-cont">
        <?= Html::submitButton(
            Yii::t('app', 'Save'),
            ['class' => 'btn btn-success']
        ) ?>

        <?= Html::a(
            Yii::t('app', 'Cancel'),
            ['/catalog/factory-product/list'],
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!-- rules box -->
<div class="add-itprod-rules">
    <div class="add-itprod-rules-item">

        <?= Yii::$app->param->getByName('PARTNER_SALE_TEXT') ?>

    </div>
</div>
<!-- rules box end -->