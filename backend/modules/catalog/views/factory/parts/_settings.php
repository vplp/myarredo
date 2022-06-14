<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Factory, FactoryLang
};
use backend\modules\location\models\Country;

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

$visible = in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])
    ? true
    : false;
?>

<?= $form->text_line($model, 'alias', ['readonly' => !$visible]) ?>

<?= $form->text_line_lang($model, 'title', ['readonly' => !$visible]) ?>

<?= $form->field($model, 'producing_country_id')->selectOne(Country::dropDownList()) ?>

<?php if ($visible) { ?>
    <?= $form->text_line($model, 'url') ?>

    <?= $form->text_line($model, 'email') ?>

    <?= $form->text_line($model, 'partner_id') ?>

    <?= $form->text_line($model, 'video') ?>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->switcher($model, 'published') ?>
        </div>
        <div class="col-md-3">
            <?= $form->text_line($model, 'position') ?>
        </div>
    </div>

    <?= $form->switcher($model, 'alternative') ?>
    <?= $form->switcher($model, 'new_price') ?>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->switcher($model, 'novelty') ?>
        </div>
        <div class="col-md-9">
            <?= $form->text_line($model, 'novelty_url') ?>
        </div>
    </div>

    <?= $form->text_line($model, 'country_code') ?>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->switcher($model, 'popular') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'popular_by') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'popular_ua') ?>
        </div>
    </div>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->switcher($model, 'show_for_ru') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'show_for_by') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'show_for_ua') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'show_for_com') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'show_for_de') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'to_translate') ?>
        </div>
    </div>

<?php } ?>

<?php if ($model->user_id) { ?>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form
                ->field($model, 'created_at')
                ->textInput(['disabled' => true, 'value' => date('d.m.Y H:i', $model->created_at)]) ?>
        </div>
        <div class="col-md-3">
            <?= $form
                ->field($model, 'user_id')
                ->textInput(['disabled' => true, 'value' => $model->user->profile->getFullName()]) ?>
        </div>
    </div>
<?php } ?>


