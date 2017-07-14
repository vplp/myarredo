<?php

/**
 * @var \backend\modules\catalog\models\Category $model
 * @var \backend\modules\catalog\models\CategoryLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'composition_title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->text_line($model, 'position') ?>
<div class="row control-group">
    <div class="col-md-6">
        <?= $form->switcher($model, 'popular') ?>
    </div>
    <div class="col-md-6">
        <?= $form->switcher($model, 'popular_by') ?>
    </div>
</div>
