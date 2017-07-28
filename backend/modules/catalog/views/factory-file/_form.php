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
<?= Html::activeHiddenInput($model, 'factory_id', ['value' => $this->context->factory->id]) ?>
<?= Html::activeHiddenInput($model, 'file_type', ['value' => $this->context->file_type]) ?>
<?= $form->text_line_lang($model, 'title') ?>
<?= $form->text_line($model, 'discount') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>