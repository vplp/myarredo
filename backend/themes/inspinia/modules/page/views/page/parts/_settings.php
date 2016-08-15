<?php
/**
 * @var backend\modules\page\models\Page $model
 * @var backend\modules\page\models\PageLang $modelLang
 * @var \backend\themes\inspinia\widgets\forms\ActiveForm $form
 */
?>

<?= $form->field($modelLang, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'published')->checkbox() ?>
