<?php
use backend\modules\news\models\Group;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @var \backend\modules\news\models\Article $model
 * @var \backend\modules\news\models\ArticleLang $modelLang
 * @var \backend\widgets\forms\ActiveForm $form
 */
?>
<?= $form->field($model, 'group_id')->hiddenInput(['value' => 1])->label(false) ?>
<?= $form->field($model, 'group_id')->dropDownList(Group::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose group') . '---']) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->text_line_lang($modelLang, 'description')->textarea([
    'style' => 'height:100px;'
]) ?>
<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'published_time')->datePicker($model->getPublishedTime()) ?>
    </div>
</div>
