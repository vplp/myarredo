<?php

use backend\widgets\forms\ActiveForm;
use backend\modules\location\models\{
    Country, City, CityLang
};

/**
 * @var City $model
 * @var CityLang $modelLang
 * @var ActiveForm $form
 */

?>

<?= $form->text_line($model, 'alias') ?>
<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form->text_line_lang($modelLang, 'title_where') ?>
<?= $form->field($model, 'country_id')->selectOne(Country::dropDownList()) ?>

<?= $form->text_line($model, 'jivosite') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'show_price') ?>
    </div>
</div>

