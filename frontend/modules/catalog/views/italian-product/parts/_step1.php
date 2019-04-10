<?php

use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
//
use frontend\modules\location\models\Region;
use frontend\modules\catalog\models\{
    Category, Factory, Types, Specification, Colors, ItalianProduct, ItalianProductLang
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
        <div class="progress-steps-box">
            <div class="progress-steps-step<?= !Yii::$app->request->get('step') ? ' active' : '' ?>">
                <span class="step-numb">1</span>
                <span class="step-text"><?= Yii::t('app', 'Информация про товар') ?></span>
            </div>
            <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'photo' ? ' active' : '' ?>">
                <span class="step-numb">2</span>
                <span class="step-text"><?= Yii::t('app', 'Фото товара') ?></span>
            </div>
            <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'check' ? ' active' : '' ?>">
                <span class="step-numb">3</span>
                <span class="step-text"><?= Yii::t('app', 'Проверка товара') ?></span>
            </div>
            <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'payment' ? ' active' : '' ?>">
                <span class="step-numb">4</span>
                <span class="step-text"><?= Yii::t('app', 'Оплата') ?></span>
            </div>
        </div>
        <!-- steps box end -->

        <?php $form = ActiveForm::begin([
            'action' => ($model->isNewRecord)
                ? Url::toRoute(['/catalog/italian-product/create'])
                : Url::toRoute(['/catalog/italian-product/update', 'id' => $model->id]),
            'fieldConfig' => [
                'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
                'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
            ],
        ]); ?>

        <?= $form->field($modelLang, 'title') ?>

        <?= $form
            ->field($model, 'catalog_type_id')
            ->widget(Select2::class, [
                'data' => Types::dropDownList(),
                'options' => ['placeholder' => Yii::t('app', 'Select option')],
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
            if (in_array($Specification['id'], [60])) {
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

        <?= $form->field($modelLang, 'defects')->textarea() ?>

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
                $value = null;
                foreach ($specification_value as $k => $v) {
                    if ($v == $Specification['id']) {
                        $value = $k;
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
                                'placeholder' => Yii::t('app', 'Select option')
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

        <?= $form
            ->field($model, 'region_id')
            ->widget(Select2::class, [
                'data' => Region::dropDownList(4),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select option'),
                ],
            ]) ?>

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

        <?= $form
            ->field(
                $model,
                'price',
                ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
            ) ?>

        <?= $form
            ->field(
                $model,
                'price_without_technology',
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

            <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_STEP1_TEXT') ?>

            <!--<h4 class="additprod-title">Помни это...</h4>
    <div class="additprod-textbox">
        <p>
            Обьявление будет опубликовано если оно соответствует правилам Myarredo
        </p>
        <p>
            Не вводите одно и то же обьявление несколько раз
        </p>
    </div>
    <div class="panel-additprod-rules">
        <a href="#" class="btn-myarredo">
            <i class="fa fa-question-circle" aria-hidden="true"></i>
            Правила
        </a>
    </div>-->
        </div>
    </div>
    <!-- rules box end -->

<?php

$url = Url::toRoute('/catalog/factory-product/ajax-get-category');
$urlGetCities = Url::toRoute('/location/location/get-cities');

$script = <<<JS
var type_id = $('#italianproduct-catalog_type_id').find('option:selected').val();

if (type_id == 3) {
     $('.field-specification-for-kitchen').show();
} else {
    $('.field-specification-for-kitchen').hide();
    $('#select-specification-for-kitchen option').attr('selected', false).trigger("change");
}

var material_id = $('select[name="SpecificationValue[2]"]').find('option:selected').val();
var material_text = $('input[name="ItalianProductLang[material]"]').val();

if (!isNaN(material_id) && material_text != '') {
    $('.field-specification-for-kitchen').show();
} else {
    $('#italianproductlang-material').hide();
}

$('select[name="SpecificationValue[2]"]').on('change', function () {
    if ($(this).val() == 0) {
        $('#italianproductlang-material').show();
    } else {
        $('#italianproductlang-material').hide();
    }
});

$('#italianproduct-catalog_type_id').on('change', function () {
    var type_id = $(this).find('option:selected').val();
    
    if (type_id == 3) {
         $('.field-specification-for-kitchen').show();
    } else {
        $('.field-specification-for-kitchen').hide();
        $('#select-specification-for-kitchen option').attr('selected', false).trigger("change");
    }
    
    $.post('$url',
        {
            _csrf: $('#token').val(),
            type_id: type_id
        }
    ).done(function (data) {
        var html = '';
        $.each(data.category, function( key, value ) {
           html += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#italianproduct-category_ids').html(html);
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

$this->registerJs($script, yii\web\View::POS_READY);
