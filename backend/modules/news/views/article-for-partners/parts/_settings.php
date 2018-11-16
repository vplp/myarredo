<?php

use backend\modules\news\models\{
    ArticleForPartners, ArticleForPartnersLang
};

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
