<?php

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

$visible = in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])
    ? true
    : false;

?>

<?= $form->text_line($model, 'alias', ['readonly' => !$visible]) ?>

<?= $form->text_line_lang($model, 'title', ['readonly' => !$visible]) ?>

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
    </div>

<?php } ?>