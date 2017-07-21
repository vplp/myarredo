<?php

use thread\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\Specification;

/**
 * @var \backend\modules\news\models\Specification $model
 * @var \backend\modules\news\models\SpecificationLang $modelLang
 */

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form
    ->field($model, 'parent_id')
    ->dropDownList(
        Specification::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose factory') . '---']
    ) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->switcher($model, 'type') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
