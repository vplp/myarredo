<?php

use kartik\widgets\Select2;
use backend\modules\catalog\models\{
    FactoryCatalogsFiles, FactoryPricesFiles
};

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<p>Прайсы и каталоги зависит от выбранной фабрики</p>

<?php if ($model->factory_id): ?>

    <?= $form
        ->field($model, 'factory_catalogs_files_ids')
        ->widget(Select2::class, [
            'data' => FactoryCatalogsFiles::dropDownList([
                'factory_id' => $model['factory_id'],
                //'file_type' => '1'
            ]),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]) ?>

    <?= $form
        ->field($model, 'factory_prices_files_ids')
        ->widget(Select2::class, [
            'data' => FactoryPricesFiles::dropDownList([
                'factory_id' => $model['factory_id'],
                //'file_type' => '2'
            ]),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]) ?>

<?php endif; ?>
