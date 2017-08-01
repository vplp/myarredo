<?php

use backend\modules\catalog\models\{
    Factory, Collection, Types
};

/**
 * @var \backend\modules\catalog\models\Sale $model
 * @var \backend\modules\catalog\models\SaleLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>

<?= $form
    ->field($model, 'catalog_type_id')
    ->dropDownList(
        Types::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose catalog type') . '---']
    ) ?>

<?= $form
    ->field($model, 'factory_id')
    ->dropDownList(
        Factory::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose factory') . '---']
    ) ?>

<?= $form->text_line($model, 'factory_name') ?>

<?= $form->text_editor_lang($modelLang, 'description') ?>
<?= $form->text_editor_lang($modelLang, 'content') ?>


<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>

