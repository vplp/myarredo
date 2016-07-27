<?php

use thread\widgets\HtmlForm;
use yii\helpers\Html;

?>

<?php Html::activeHiddenInput($model, 'model_id') ?>
<?php Html::activeHiddenInput($model, 'model_namespace') ?>

<?php HtmlForm::textInput($modelLang, 'title', ['maxlength' => 75]) ?>
<?php HtmlForm::textInput($modelLang, 'description', ['maxlength' => 155]) ?>
<?php HtmlForm::textInput($modelLang, 'keywords', ['maxlength' => 255]) ?>

<?php HtmlForm::switcher($model, 'in_search') ?>
<?php HtmlForm::switcher($model, 'in_robots') ?>
<?php HtmlForm::switcher($model, 'in_site_map') ?>

