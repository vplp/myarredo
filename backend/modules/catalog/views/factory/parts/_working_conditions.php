<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Factory, FactoryLang
};

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

?>

<?= $form->field($model, 'factory_discount'); ?>

<?= $form->text_line_lang($modelLang, 'wc_provider'); ?>
<?= $form->text_line_lang($modelLang, 'wc_phone'); ?>
<?= $form->text_line_lang($modelLang, 'wc_email'); ?>
<?= $form->text_line_lang($modelLang, 'wc_prepayment'); ?>
<?= $form->text_line_lang($modelLang, 'wc_balance'); ?>
<?= $form->text_line_lang($modelLang, 'wc_additional_terms')->textarea(['style' => 'height:200px;']); ?>
