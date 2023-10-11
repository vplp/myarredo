<?php

use yii\helpers\{
    Html
};
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Factory, FactoryLang
};

/**
 * @var $form ActiveForm
 * @var $model Factory
 * @var $modelLang FactoryLang
 */

$currentLanguage = Yii::$app->language;
Yii::$app->language = 'ru-RU';

$dataLang = FactoryLang::find()->where(['rid' => $model['id']])->one();

Yii::$app->language = $currentLanguage;
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<?= Html::activeHiddenInput($model, 'id', ['value' => $model->id]) ?>

<?php if (Yii::$app->language != 'ru-RU') { ?>
    <div style="border: 1px solid red; padding: 5px;  margin-bottom: 20px"><?= $dataLang['description'] ?></div>
<?php } ?>

<?= $form->text_editor_lang($modelLang, 'description') ?>

<?php if (Yii::$app->language != 'ru-RU') { ?>
    <div style="border: 1px solid red; padding: 5px;  margin-bottom: 20px"><?= $dataLang['content'] ?></div>
<?php } ?>

<?= $form->text_editor_lang($modelLang, 'content') ?>

<?php if (Yii::$app->language != 'ru-RU') { ?>
    <div style="border: 1px solid red; padding: 5px;  margin-bottom: 20px"><?= $dataLang['contacts'] ?></div>
<?php } ?>

<?= $form->text_editor_lang($modelLang, 'contacts') ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end(); ?>
