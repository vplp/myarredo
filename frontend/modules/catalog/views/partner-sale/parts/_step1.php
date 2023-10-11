<?php

use backend\app\bootstrap\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
use frontend\modules\catalog\models\{
    Sale, SaleLang, Category, Factory, Types, SubTypes, Specification, Colors
};
use frontend\modules\location\models\{
    Country, City
};

/**
 * @var $model Sale
 * @var $modelLang SaleLang
 * @var $Specification Specification
 */

?>

    <div class="form-horizontal add-itprod-content">

        <!-- steps box -->

        <?= $this->render('_steps_box') ?>

        <!-- steps box end -->

        <?php $form = ActiveForm::begin([
            'id' => 'formPartnerSaleCreate',
            'action' => ($model->isNewRecord)
                ? Url::toRoute(['/catalog/partner-sale/create'])
                : Url::toRoute(['/catalog/partner-sale/update', 'id' => $model->id]),
            'fieldConfig' => [
                'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
                'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
            ]
        ]); ?>

        <?= $form->field($modelLang, 'title') ?>

        <?= $form
            ->field($model, 'catalog_type_id')
            ->label(Yii::t('app', 'Предмет'))
            ->widget(Select2::class, [
                'data' => Types::dropDownList(),
                'options' => ['placeholder' => Yii::t('app', 'Select option')],
            ]) ?>

        <?= $form
            ->field($model, 'subtypes_ids')
            ->widget(Select2::class, [
                'data' => SubTypes::dropDownList(['parent_id' => $model->isNewRecord ? -1 : $model['catalog_type_id']]),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select option'),
                    'multiple' => true
                ],
            ]) ?>

        <?= $form
            ->field($model, 'category_ids')
            ->widget(Select2::class, [
                'data' => Category::dropDownList([
                    'type_id' => $model->isNewRecord ? null : $model['catalog_type_id']
                ]),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select option'),
                    'multiple' => true
                ],
            ]) ?>

        <?= $form
            ->field($model, 'factory_id')
            ->widget(Select2::class, [
                'data' => Factory::dropDownList(),
                'options' => ['placeholder' => Yii::t('app', 'Select option')],
            ]) ?>

        <?= $form->field($model, 'factory_name') ?>

        <?= $form->field($modelLang, 'description')->textarea() ?>

        <?php
        $specification_value = $model->getSpecificationValueBySpecification();
        foreach (Specification::findBase()->all() as $Specification) {
            if ($Specification['type'] === '1' && !in_array($Specification['id'], [39, 47])) { ?>
                <div class="form-group row">
                    <?= Html::label(
                        $Specification['lang']['title'] . ' (' . Yii::t('app', 'см') . ')',
                        null,
                        ['class' => 'col-sm-3 col-form-label']
                    ) ?>
                    <div class="col-sm-2">
                        <?= Html::input(
                            'number',
                            'SpecificationValue[' . $Specification['id'] . ']',
                            !empty($specification_value[$Specification['id']])
                                ? $specification_value[$Specification['id']]
                                : null,
                            ['class' => 'form-control']
                        ) ?>
                    </div>
                </div>
            <?php } elseif (in_array($Specification['id'], [2, 9])) {
                $value = null;
                foreach ($specification_value as $k => $v) {
                    if ($v == $Specification['id']) {
                        $value = $k;
                    }
                }
                ?>
                <div class="form-group field-sale-specification-value-<?= $Specification['id'] ?>">
                    <?= Html::label(
                        $Specification['lang']['title'],
                        null,
                        ['class' => 'col-sm-3 col-form-label']
                    ) ?>
                    <div class="col-sm-9">
                        <?= Select2::widget([
                            'name' => 'SpecificationValue[' . $Specification['id'] . ']',
                            'value' => $value,
                            'data' => $Specification->getChildrenDropDownList(),
                            'options' => [
                                'placeholder' => Yii::t('app', 'Select option')
                            ]
                        ]) ?>
                    </div>
                    <p class="help-block help-block-error" style="display: none"><?= Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $Specification['lang']['title']]) ?></p>
                </div>
            <?php } ?>
        <?php } ?>

        <?= $form
            ->field($model, 'colors_ids')
            ->widget(Select2::class, [
                'data' => Colors::dropDownList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select option'),
                    'multiple' => true
                ],
            ]) ?>

        <?= $form->field(
            $model,
            'volume',
            ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
        ) ?>

        <?= $form
            ->field(
                $model,
                'price',
                ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
            ) ?>

        <div class="form-group row price-row">
            <?= $form
                ->field(
                    $model,
                    'price_new',
                    [
                        'template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}",
                        'options' => [
                            'class' => '',
                        ]
                    ]
                ) ?>

            <?= $form
                ->field(
                    $model,
                    'currency',
                    [
                        'template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}",
                        'options' => [
                            'class' => '',
                        ]
                    ]
                )
                ->dropDownList($model::currencyRange())
                ->label(false) ?>

        </div>

        <?= Html::activeHiddenInput($model, 'country_id', ['value' => Yii::$app->user->identity->profile->country_id]) ?>
        <?= Html::activeHiddenInput($model, 'city_id', ['value' => Yii::$app->user->identity->profile->city_id]) ?>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label"><?= Yii::t('app', 'Status') ?></label>
            <div class="col-sm-4">
                <div class="checkbox checkbox-primary">
                    <?= $form
                        ->field(
                            $model,
                            'published',
                            [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => [
                                    'class' => '',
                                ]
                            ]
                        )
                        ->checkbox([], false)
                        ->label() ?>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label"></label>
            <div class="col-sm-4">
                <div class="checkbox checkbox-primary">
                    <?= $form
                        ->field(
                            $model,
                            'is_sold',
                            [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => [
                                    'class' => '',
                                ]
                            ]
                        )
                        ->checkbox([], false)
                        ->label() ?>
                </div>
            </div>
        </div>

        <div class="buttons-cont">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            <?= Html::a(
                Yii::t('app', 'Вернуться к списку'),
                ['/catalog/partner-sale/list'],
                ['class' => 'btn btn-primary']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php

$url = Url::toRoute('/catalog/factory-product/ajax-get-category');
$urlGetCities = Url::toRoute('/location/location/get-cities');
$script = <<<JS
$('#sale-catalog_type_id').on('change', function () {
    $.post('$url',
        {
            _csrf: $('#token').val(),
            type_id: $(this).find('option:selected').val()
        }
    ).done(function (data) {
        var category = '';
        $.each(data.category, function( key, value ) {
           category += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#sale-category_ids').html(category);
        
        var subtypes = '';
        $.each(data.subtypes, function( key, value ) {
           subtypes += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#sale-subtypes_ids').html(subtypes);
    });
});
$('select#sale-country_id').change(function(){
    var country_id = parseInt($(this).val());
    $.post('$urlGetCities', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#sale-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});

$('.field-sale-specification-value-9').addClass('required');

$('body').on('beforeSubmit', 'form#formPartnerSaleCreate', function () {
    var form = $(this);

    if ($('.field-sale-specification-value-9').find('option:selected').val()) {
        $('.field-sale-specification-value-9').addClass('has-success').removeClass('has-error');
        $('.field-sale-specification-value-9').find('.help-block').hide();
    } else {
        $('.field-sale-specification-value-9').addClass('has-error');
        $('.field-sale-specification-value-9').find('.help-block').show();
    }
    
    if (form.find('.has-error').length) {
        return false;
    }
});
JS;

$this->registerJs($script);
