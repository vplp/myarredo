<?php

/**
 * @var \backend\modules\catalog\models\Types $model
 * @var \backend\modules\catalog\models\TypesLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'plural_name') ?>
<?= $form->text_line($model, 'alias') ?>
<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>

