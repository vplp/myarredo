<?php

use backend\app\bootstrap\ActiveForm;

/**
 * @var ActiveForm $form
 * @var \backend\modules\location\models\Country $model
 * @var \backend\modules\location\models\CountryLang $modelLang
 */

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->text_line($model, 'alias') ?>
        </div>
    </div>
<?= $form->text_line_lang($modelLang, 'title') ?>
<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
