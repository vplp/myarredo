<?php

use thread\app\bootstrap\ActiveForm;
//
use backend\modules\location\models\Country;

/**
 * @var $model \backend\modules\location\models\City
 * @var $modelLang \backend\modules\location\models\CityLang
 * @var $form \backend\themes\defaults\widgets\forms\ActiveForm
 */

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->field($model, 'country_id')->selectOne(Country::dropDownList()) ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
