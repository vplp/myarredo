<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category
};

/**
 * @var \backend\modules\catalog\models\Types $model
 * @var \backend\modules\catalog\models\TypesLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?= $form
    ->field($model, 'category_ids')
    ->widget(Select2::classname(), [
        'data' => Category::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]) ?>