<?php

use backend\app\bootstrap\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
//
use frontend\modules\catalog\models\{
    Category, Factory, Types, Specification
};
use frontend\modules\location\models\{
    Country, City
};

/**
 * @var \frontend\modules\catalog\models\Sale $model
 * @var \frontend\modules\catalog\models\SaleLang $modelLang
 * @var \frontend\modules\catalog\models\Specification $Specification
 */

$this->title = ($model->isNewRecord) ? Yii::t('app','Add') : Yii::t('app','Edit');

?>

<main>
    <div class="page create-sale">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="column-center">
                <div class="form-horizontal">

                    <?php $form = ActiveForm::begin([
                        'action' => ($model->isNewRecord)
                            ? Url::toRoute(['/catalog/partner-sale/create'])
                            : Url::toRoute(['/catalog/partner-sale/update', 'id' => $model->id]),
                        'fieldConfig' => [
                            'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
                            'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
                        ],
                    ]); ?>

                    <?php if ($model->isNewRecord): ?>

                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            Для загрузки изображений - сначала создайте товар
                        </div>

                    <?php else: ?>

                        <?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>

                        <?= $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]) ?>

                    <?php endif; ?>

                    <?= $form->field($modelLang, 'title') ?>

                    <?= $form
                        ->field($model, 'category_ids')
                        ->widget(Select2::classname(), [
                            'data' => Category::dropDownList(),
                            'options' => [
                                'placeholder' => Yii::t('app', 'Select option'),
                                'multiple' => true
                            ],
                        ]) ?>

                    <?= $form
                        ->field($model, 'catalog_type_id')
                        ->widget(Select2::classname(), [
                            'data' => Types::dropDownList(),
                            'options' => ['placeholder' => Yii::t('app', 'Select option')],
                        ]) ?>

                    <?= $form
                        ->field($model, 'factory_id')
                        ->widget(Select2::classname(), [
                            'data' => Factory::dropDownList(),
                            'options' => ['placeholder' => Yii::t('app', 'Select option')],
                        ]) ?>

                    <?= $form->field($model, 'factory_name') ?>

                    <?= $form->field($modelLang, 'description')->textarea() ?>

                    <?php
                    $specification_value = $model->getSpecificationValueBySpecification();
                    foreach (Specification::findBase()->all() as $Specification): ?>

                        <?php if ($Specification['type'] === '1' && !in_array($Specification['id'], [39, 47])): ?>

                            <div class="form-group row">
                                <?= Html::label($Specification['lang']['title'], null, ['class' => 'col-sm-3 col-form-label']) ?>
                                <div class="col-sm-2">
                                    <?= Html::input(
                                        'text',
                                        'SpecificationValue[' . $Specification['id'] . ']',
                                        !empty($specification_value[$Specification['id']]) ? $specification_value[$Specification['id']] : null,
                                        ['class' => 'form-control']
                                    ) ?>
                                </div>
                            </div>

                        <?php elseif (in_array($Specification['id'], [2, 9])): ?>
                            <div class="form-group row">
                                <?= Html::label($Specification['lang']['title'], null, ['class' => 'col-sm-3 col-form-label']) ?>
                                <div class="col-sm-9">
                                    <?= Select2::widget([
                                        'name' => 'SpecificationValue[' . $Specification['id'] . ']',
                                        'value' => !empty($specification_value[$Specification['id']]) ? $specification_value[$Specification['id']] : null,
                                        'data' => $Specification->getChildrenDropDownList(),
                                        'options' => ['placeholder' => Yii::t('app', 'Select option')]
                                    ]) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>

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
                    <div class="form-group row">
                        <?= $form->field(
                            $model,
                            'country_id',
                            [
                                'template' => "{label}<div class=\"col-sm-4\">{input}</div>\n{hint}\n{error}",
                                'options' => [
                                    'class' => '',
                                ]
                            ])
                            ->dropDownList(
                                [null => '--'] + Country::dropDownList(),
                                ['class' => 'selectpicker']
                            ); ?>
                    </div>
                    <div class="form-group row">
                        <?= $form->field(
                            $model,
                            'city_id',
                            [
                                'template' => "{label}<div class=\"col-sm-4\">{input}</div>\n{hint}\n{error}",
                                'options' => [
                                    'class' => '',
                                ]
                            ])
                            ->dropDownList(
                                [null => '--'] + City::dropDownList($model->country_id),
                                ['class' => 'selectpicker']
                            ); ?>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Статус</label>
                        <div class="col-sm-9">
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

                    <div class="buttons-cont">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary btn-lg']) ?>
                        <?= Html::a(Yii::t('app', 'Cancel'), ['/catalog/partner-sale/list'], ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</main>

<?php

$script = <<<JS
$('select#registerform-country_id').change(function(){
    var country_id = parseInt($(this).val());
    $.post('/location/location/get-cities/', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#registerform-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>