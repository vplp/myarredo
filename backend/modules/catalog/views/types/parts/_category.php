<?php

use backend\modules\catalog\models\TypesRelCategory;
//
use backend\themes\defaults\widgets\TreeGrid;

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category
};

?>

<?= $form
    ->field($model, 'category_ids')
    ->widget(Select2::classname(), [
        'data' => Category::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Choose category'),
            'multiple' => true
        ],
    ]) ?>