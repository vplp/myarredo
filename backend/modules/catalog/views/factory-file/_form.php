<?php

use yii\helpers\{
    Html, Url
};
use backend\app\bootstrap\ActiveForm;

/**
 * @var $form \backend\app\bootstrap\ActiveForm
 * @var $model \backend\modules\catalog\models\FactoryFile
 */

$this->context->actionListLinkStatus = Url::to(
    [
        '/catalog/factory/update',
        'id' => ($this->context->factory->id !== null) ? $this->context->factory->id : 0,
    ]
);
/*
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<?php if ($this->context->file_type == 1): ?>
    <?= Html::tag('h2', Yii::t('app', 'Catalogs')); ?>
    <?= $form->field($model, 'file_link')->fileInputWidget(
        $model->getFileLink(),
        ['accept' => '.doc,.docx,.xlsx,application/pdf', 'maxFileSize' => 0],
        ['pdf', 'doc', 'docx', 'xlsx']
    ) ?>
<?php else: ?>
    <?= Html::tag('h2', Yii::t('app', 'Prices')); ?>
    <?= $form->field($model, 'file_link')->fileInputWidget(
        $model->getFileLink(),
        ['accept' => '.doc,.docx,.xlsx,application/pdf', 'maxFileSize' => 0],
        ['pdf', 'doc', 'docx', 'xlsx']
    ) ?>
    <?= $form->text_line($model, 'discount') ?>
<?php endif; ?>

<?= Html::activeHiddenInput($model, 'factory_id', ['value' => $this->context->factory->id]) ?>
<?= Html::activeHiddenInput($model, 'file_type', ['value' => $this->context->file_type]) ?>
<?= $form->text_line($model, 'title') ?>

<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); */ ?>