<?php

use backend\modules\location\models\Country;

/**
 * @var $model \backend\modules\location\models\Region
 * @var $modelLang \backend\modules\location\models\RegionLang
 * @var $form \backend\widgets\forms\ActiveForm
 */

?>

<?= $form->text_line($model, 'alias') ?>
<?= $form->text_line_lang($modelLang, 'title', ['placeholder' => $model->getTitle()]) ?>

<?= $form->field($model, 'country_id')->selectOne(Country::dropDownList()) ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
</div>