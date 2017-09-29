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
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->text_line($model, 'alias') ?>
        </div>
    </div>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'title_where') ?>
<?= $form->field($model, 'country_id')->selectOne(Country::dropDownList()) ?>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->text_line($model, 'lat') ?>
        </div>
        <div class="col-md-3">
            <?= $form->text_line($model, 'lng') ?>
        </div>
    </div>
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
