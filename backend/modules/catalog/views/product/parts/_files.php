<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\FactoryFile;

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */

?>

<p>Прайсы и каталоги зависит от выбранной фабрики</p>

<?php if ($model->factory_id): ?>

    <?= $form
        ->field($model, 'factoryCatalogsFiles')
        ->widget(Select2::classname(), [
            'data' => FactoryFile::dropDownList([
                'factory_id' => $model['factory_id'],
                'file_type' => '1'
            ]),
            'options' => [
                'placeholder' => Yii::t('app', 'Choose file'),
                'multiple' => true
            ],
        ]) ?>

    <?= $form
        ->field($model, 'factoryPricesFiles')
        ->widget(Select2::classname(), [
            'data' => FactoryFile::dropDownList([
                'factory_id' => $model['factory_id'],
                'file_type' => '2'
            ]),
            'options' => [
                'placeholder' => Yii::t('app', 'Choose file'),
                'multiple' => true
            ],
        ]) ?>

<?php endif; ?>