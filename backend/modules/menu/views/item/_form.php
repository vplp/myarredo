<?php

use yii\helpers\Html;
use backend\app\bootstrap\ActiveForm;
use backend\modules\menu\models\MenuItem;

$type = array_keys(MenuItem::linkTypeRange())[0];
if (isset($model['link_type'])) {
    $type = $model['link_type'];
}

if (empty($model['internal_source'])):
    $model['internal_source'] = array_keys(MenuItem::getSourcesList())[0];
endif;
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= Html::activeHiddenInput($model, 'group_id', ['value' => $this->context->group->id]) ?>
<?= Html::activeHiddenInput($model, 'parent_id',
    [
        'value' => (Yii::$app->request->get('parent_id'))
            ? Yii::$app->request->get('parent_id')
            : 0
    ]
) ?>

<?= $form->text_line_lang($modelLang, 'title') ?>
    <hr>
<?= $form->field($model, 'link_type')->dropDownList(MenuItem::linkTypeRange()) ?>

    <div class="menuitem-link_type_internal" style="display:<?= ($type == 'internal') ? 'block' : 'none' ?>">
        <?= $form->field($model, 'internal_source')->dropDownList(MenuItem::getTypeSources(), ['prompt' => '']) ?>

        <?php foreach (MenuItem::getSourcesList() as $key => $data):
            echo Html::beginTag('div', [
                'class' => $key . ' internal_sources',
                'style' => 'display:' . (($model['internal_source'] == $key) ? 'block' : 'none')
            ]);
            echo $form->field($model, 'internal_source_id')->dropDownList(call_user_func([$data['class'], $data['method']]), ['prompt' => ''])->label($data['label']);
            echo Html::endTag('div');
        endforeach;
        echo $form->field($model, 'internal_source_id', ['inputOptions' => ['class' => 'internal_source_id_hidden']])->hiddenInput()->label(false);
        ?>

    </div>

    <div class="menuitem-link_type_external" style="display:<?= ($type == 'external') ? 'block' : 'none' ?>">
        <?= $form->text_line($model, 'external_link', [
            'inputOptions' => [
                'id' => 'link_type_external'
            ]
        ]) ?>
        <?= $form->field($model, 'link_target')->dropDownList(MenuItem::linkTargetRange()) ?>
    </div>

    <div class="menuitem-link_type_permanent" style="display:<?= ($type == 'permanent') ? 'block' : 'none' ?>">
        <?= $form->field($model, 'permanent_link', [
            'inputOptions' => [
                'id' => 'link_type_permanent'
            ]
        ])->dropDownList(MenuItem::getPermanentLink()) ?>
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
<?php ActiveForm::end(); ?>

<?php
$script = <<<JS
$(document).on('change', '#menuitem-link_type', function () {
    var val = this.value;

    if (this.value == 'permanent') {
        $('.menuitem-link_type_permanent').show();
        $('.menuitem-link_type_external').hide();
        $('.menuitem-link_type_internal').hide();
    } else if(this.value == 'internal') {
        $('.menuitem-link_type_internal').show();
        $('.menuitem-link_type_external').hide();
        $('.menuitem-link_type_permanent').hide();
    } else {
        $('.menuitem-link_type_internal').hide();
        $('.menuitem-link_type_external').show();
        $('.menuitem-link_type_permanent').hide(); 
    }
});

$(document).on('change', '#menuitem-internal_source', function () {
    var val = this.value;
    $('.internal_sources').hide();
    $('.'+val).show();
});

$(document).on('change', '#menuitem-internal_source_id', function () {
    var val = this.value;
    $('.internal_source_id_hidden').val(val);
});
JS;

$this->registerJs($script);
