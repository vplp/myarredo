<?php

use yii\helpers\{
    Html, Url
};
use backend\app\bootstrap\ActiveForm;

/**
 * @var $form \backend\app\bootstrap\ActiveForm
 * @var $model \backend\modules\catalog\models\FactoryPricesFiles
 */

$this->context->actionListLinkStatus = Url::to(
    [
        '/catalog/factory/update',
        'id' => ($this->context->factory->id !== null) ? $this->context->factory->id : 0,
    ]
);

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>

    <?= Html::tag('h2', Yii::t('app', 'Prices')); ?>
    <?= $form->field($model, 'file_link')->fileInputWidget(
        $model->getFileLink(),
        ['accept' => '.doc,.docx,.xlsx,application/pdf', 'maxFileSize' => 0],
        ['pdf', 'doc', 'docx', 'xlsx']
    ) ?>
    <?= $form->text_line($model, 'discount') ?>

<?= Html::activeHiddenInput($model, 'factory_id', ['value' => $this->context->factory->id]) ?>

<?= $form->text_line($model, 'title') ?>

<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>

<?php ActiveForm::end(); ?>