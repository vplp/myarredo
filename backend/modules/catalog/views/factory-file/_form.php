<?php

use yii\helpers\{
    Html, Url
};
use thread\app\bootstrap\{
    ActiveForm
};


$this->context->actionListLinkStatus = Url::to(
    [
        '/catalog/factory/update',
        'id' => ($this->context->factory->id !== null) ? $this->context->factory->id : 0,
    ]
);
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<?php if ($this->context->file_type == 1): ?>
    <?= Html::tag('h2', Yii::t('app', 'Catalogs')); ?>
    <?php //$form->field($model, 'file_link')->imageOne($model->getFactoryFileCatalogsImage()) ?>
<?php else: ?>
    <?= Html::tag('h2', Yii::t('app', 'Prices')); ?>
    <?php //$form->field($model, 'file_link')->imageOne($model->getFactoryFilePricesImage()) ?>
    <?= $form->text_line($model, 'discount') ?>
<?php endif; ?>

<?= Html::activeHiddenInput($model, 'factory_id', ['value' => $this->context->factory->id]) ?>
<?= Html::activeHiddenInput($model, 'file_type', ['value' => $this->context->file_type]) ?>
<?= $form->text_line($model, 'title') ?>

<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>