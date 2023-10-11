<?php

use kartik\widgets\Select2;
use backend\modules\catalog\models\Samples;

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */
?>

<p>Отделка зависит от выбранной фабрики</p>

<?php if ($model->factory_id): ?>

    <?= $form
        ->field($model, 'samples_ids')
        ->widget(Select2::class, [
            'data' => Samples::dropDownList(['factory_id' => $model['factory_id']]),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]) ?>

<?php endif; ?>
