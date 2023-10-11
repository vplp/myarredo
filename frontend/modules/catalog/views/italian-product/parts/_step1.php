<?php

use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
//
use frontend\modules\location\models\Region;
use frontend\modules\catalog\models\{
    Category, Factory, Types, SubTypes, Specification, Colors, ItalianProduct, ItalianProductLang
};
//
use backend\app\bootstrap\ActiveForm;

/**
 * @var ItalianProduct $model
 * @var ItalianProductLang $modelLang
 * @var Specification $Specification
 */

$specification_value = $model->getSpecificationValueBySpecification();
$Specifications = Specification::findBase()->all();

?>

    <div class="form-horizontal add-itprod-content">

        <!-- steps box -->

        <?= $this->render('_steps_box') ?>

        <!-- steps box end -->

        <?php $form = ActiveForm::begin([
            'action' => ($model->isNewRecord)
                ? null
                : Url::toRoute(['/catalog/italian-product/update', 'id' => $model->id]),
            'fieldConfig' => [
                'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
                'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
            ],
        ]) ?>

        <?php

        if ($model->isNewRecord) {
            $model->create_mode = 'free';
        }

        $nds = $model->create_mode == 'paid'
            ? ' ' . Yii::t('app', 'с НДС {nds} %', ['nds' => 22])
            : '';

        echo $form->field($model, 'create_mode')
            ->label(false)
            ->input('hidden');
        ?>

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
                    'type_id' => $model->isNewRecord ? 0 : $model['catalog_type_id']
                ]),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select option'),
                    'multiple' => true
                ],
            ]) ?>

        <?= $form->field($modelLang, 'description')->textarea() ?>

        <?php
        foreach ($Specifications as $Specification) {
            if ($Specification['id'] == 60) {
                $value = [];
                foreach ($specification_value as $k => $v) {
                    if ($v == $Specification['id']) {
                        $value[] = $k;
                    }
                }
                ?>
                <div class="form-group row field-specification-for-kitchen">
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
                                'placeholder' => Yii::t('app', 'Select option'),
                                'multiple' => true,
                                'id' => 'select-specification-for-kitchen'
                            ]
                        ]) ?>
                    </div>
                </div>
            <?php }
        } ?>

        <?= $form
            ->field($modelLang, 'defects')
            ->label(Yii::t('app', 'Опишите отличительные характеристики объекта, состояние сохранности и любые дефекты'))
            ->textarea() ?>

        <?php
        /**
         * Choose Factory
         */
        if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['factory'])) {
            $model->factory_id = Yii::$app->user->identity->profile->factory_id;

            echo $form->field($model, 'factory_id')
                ->label(false)
                ->input('hidden');
        } else {
            echo $form
                ->field($model, 'factory_id')
                ->widget(Select2::class, [
                    'data' => Factory::dropDownList(),
                    'options' => ['placeholder' => Yii::t('app', 'Select option')],
                ]);
            echo $form->field($model, 'factory_name');
        } ?>

        <?= $form->text_line($model, 'article') ?>

        <?php
        foreach ($Specifications as $Specification) {
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
                <?php
            } elseif ($Specification['id'] == 2) {
                $value = [];
                foreach ($specification_value as $k => $v) {
                    if ($v == $Specification['id']) {
                        $value[] = $k;
                    }
                }
                ?>
                <div class="form-group row">
                    <?= Html::label(
                        $Specification['lang']['title'],
                        null,
                        ['class' => 'col-sm-3 col-form-label']
                    ) ?>
                    <div class="col-sm-4">
                        <?= Select2::widget([
                            'name' => 'SpecificationValue[' . $Specification['id'] . ']',
                            'value' => $value,
                            'data' => $Specification->getChildrenDropDownList() +
                                ['0' => Yii::t('app', 'Другое')],
                            'options' => [
                                'placeholder' => Yii::t('app', 'Select option'),
                                'multiple' => true,
                            ]
                        ]) ?>
                    </div>
                    <div class="col-sm-5">
                        <?= $form
                            ->field(
                                $modelLang,
                                'material',
                                ['template' => "{label}<div class=\"col-sm-12\">{input}</div>\n{hint}\n{error}"]
                            )
                            ->input(
                                'text',
                                ['placeholder' => Yii::t('app', 'Добавьте материал')]
                            )
                            ->label(false) ?>
                    </div>
                </div>

                <?php
            } elseif ($Specification['id'] == 9) {
                $value = null;
                foreach ($specification_value as $k => $v) {
                    if ($v == $Specification['id']) {
                        $value = $k;
                    }
                } ?>

                <div class="form-group row">
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

        <?= $form->field(
            $model,
            'weight',
            ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
        ) ?>


        <?= $form->field(
            $model,
            'production_year',
            ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
        ) ?>

        <?php if (isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id == 4) {
            echo $form
                ->field($model, 'region_id')
                ->widget(Select2::class, [
                    'data' => [0 => '--'] + Region::dropDownList(4),
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select option'),
                    ],
                ]);
        } ?>

        <?php
        $model->phone = $model->isNewRecord
            ? Yii::$app->user->identity->profile->phone
            : $model->phone;

        echo $form->field(
            $model,
            'phone',
            ['template' => "{label}<div class=\"col-sm-4\">{input}</div>\n{hint}\n{error}"]
        ) ?>

        <?php
        $model->email = $model->isNewRecord
            ? Yii::$app->user->identity->email
            : $model->email;
        echo $form->field(
            $model,
            'email',
            ['template' => "{label}<div class=\"col-sm-4\">{input}</div>\n{hint}\n{error}"]
        ) ?>

        <?php if ($model->create_mode == 'paid') {
            echo Html::tag('p', Yii::t('app', 'Обращаем внимание, что цена для клиента увеличится на {nds} % с учетом НДС.<br> Из практики это увеличит время продажи.', ['nds' => 22]));
        } ?>

        <?= $form
            ->field(
                $model,
                'price',
                ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
            )->label(Yii::t('app', 'Price') . $nds) ?>

        <?= $form
            ->field(
                $model,
                'price_without_technology',
                ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
            )->label(Yii::t('app', 'Price without technology') . $nds) ?>

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
                )->label(Yii::t('app', 'New price') . $nds) ?>

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

        <div class="buttons-cont">
            <?= Html::submitButton(
                Yii::t('app', 'Save'),
                ['class' => 'btn btn-success']
            ) ?>

            <?= Html::a(
                Yii::t('app', 'Cancel'),
                ['/catalog/italian-product/list'],
                ['class' => 'btn btn-primary']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <!-- rules box -->
    <div class="add-itprod-rules">
        <div class="add-itprod-rules-item">

            <?php if (isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id == 4) {
                echo Yii::$app->param->getByName('ITALIAN_PRODUCT_STEP1_TEXT');
            } ?>

            <?php if ($model->create_mode == 'paid') { ?>
                <?= Html::a(
                    '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Добавить товар без НДС'),
                    Url::toRoute(['/catalog/italian-product/free-create']),
                    ['class' => 'btn-myarredo']
                ) ?>
            <?php } ?>

        </div>
    </div>
    <!-- rules box end -->

<?php

$url = Url::toRoute('/catalog/factory-product/ajax-get-category');
$urlGetCities = Url::toRoute('/location/location/get-cities');

$script = <<<JS
var type_id = $('#italianproduct-catalog_type_id').find('option:selected').val();

if (type_id == 3) {
    $('.field-italianproduct-price_without_technology').show();
    $('.field-specification-for-kitchen').show();
} else {
    $('.field-italianproduct-price_without_technology').hide();
    $('.field-specification-for-kitchen').hide();
    $('#select-specification-for-kitchen option').attr('selected', false).trigger("change");
}

var material_ids = $('select[name="SpecificationValue[2][]"]').val();
var material_text = $('input[name="ItalianProductLang[material]"]').val();

if (material_ids.includes('0')) {
    $('.field-specification-for-kitchen').show();
} else {
    $('#italianproductlang-material').hide();
}

$('select[name="SpecificationValue[2][]"]').on('change', function () {
    if ($(this).val().includes('0')) {
        $('#italianproductlang-material').show();
    } else {
        $('#italianproductlang-material').hide();
    }
});

$('#italianproduct-catalog_type_id').on('change', function () {
    var type_id = $(this).find('option:selected').val();
    
    if (type_id == 3) {
        $('.field-italianproduct-price_without_technology').show();
        $('.field-specification-for-kitchen').show();
    } else {
        $('.field-italianproduct-price_without_technology').hide();
        $('.field-specification-for-kitchen').hide();
        $('#select-specification-for-kitchen option').attr('selected', false).trigger("change");
    }
    
    $.post('$url',
        {
            _csrf: $('#token').val(),
            type_id: type_id
        }
    ).done(function (data) {
        var category = '';
        $.each(data.category, function( key, value ) {
           category += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#italianproduct-category_ids').html(category);
        
        var subtypes = '';
        $.each(data.subtypes, function( key, value ) {
           subtypes += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#italianproduct-subtypes_ids').html(subtypes);
    });
});
// field-specification-for-kitchen
$('select#italianproduct-country_id').change(function(){
    var country_id = parseInt($(this).val());
    $.post('$urlGetCities', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#italianproduct-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});
JS;

$this->registerJs($script);
