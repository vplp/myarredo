<?php
use kartik\select2\Select2;
use backend\modules\news\models\{
    ArticleForPartners, ArticleForPartnersLang
};
use backend\modules\location\models\City;

/**
 * @var ArticleForPartners $model
 * @var ArticleForPartnersLang $modelLang
 * @var \backend\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form->text_line_lang($modelLang, 'description')->textarea([
    'style' => 'height:100px;'
]) ?>

<?= $form
    ->field($model, 'city_ids')
    ->widget(Select2::classname(), [
        'data' => City::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]) ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'show_all') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'position') ?>
    </div>
</div>
