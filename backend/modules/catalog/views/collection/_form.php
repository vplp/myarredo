<?php

use yii\helpers\{
    Html, Url
};
use backend\app\bootstrap\ActiveForm;

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
<?= Html::activeHiddenInput($model, 'first_letter') ?>
<?= $form->text_line_lang($model, 'title') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();