<?php

use yii\helpers\{
    Html
};
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Composition, CompositionLang
};

/**
 * @var $form ActiveForm
 * @var $model Composition
 * @var $modelLang CompositionLang
 */

$currentLanguage = Yii::$app->language;
Yii::$app->language = 'ru-RU';

$dataLang = CompositionLang::find()->where(['rid' => $model['id']])->one();

Yii::$app->language = $currentLanguage;
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<?= Html::activeHiddenInput($model, 'id', ['value' => $model->id]) ?>

<div style="border: 1px solid red; padding: 5px; margin-bottom: 20px"><?= $dataLang['title'] ?></div>

<?= $form->text_line_lang($modelLang, 'title') ?>

<div style="border: 1px solid red; padding: 5px;  margin-bottom: 20px"><?= $dataLang['description'] ?></div>

<?= $form->text_editor_lang($modelLang, 'description') ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end(); ?>
