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

<?= $form->text_editor_lang($modelLang, 'working_conditions'); ?>
