<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\Samples;

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */

 ?>

<p>Отделка зависит от выбранной фабрики</p>

<?php if ($model->factory_id): ?>

    <?= $form
        ->field($model, 'samples')
        ->widget(Select2::classname(), [
            'data' => Samples::dropDownList(['factory_id' => $model['factory_id']]),
            'options' => [
                'placeholder' => Yii::t('app', 'Choose samples'),
                'multiple' => true
            ],
        ]) ?>

<?php endif; ?>
