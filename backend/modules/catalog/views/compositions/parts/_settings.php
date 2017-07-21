<?php

use backend\modules\catalog\models\Factory;

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line($model, 'alias') ?>


<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form
    ->field($model, 'factory_id')
    ->dropDownList(
        Factory::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose factory') . '---']
    ) ?>

<?= $form->text_line($model, 'collections_id') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>