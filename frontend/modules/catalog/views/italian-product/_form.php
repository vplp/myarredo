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
 * @var \frontend\modules\catalog\models\ItalianProduct $model
 * @var \frontend\modules\catalog\models\ItalianProductLang $modelLang
 * @var \frontend\modules\catalog\models\Specification $Specification
 */

$this->title = (($model->isNewRecord)
        ? Yii::t('app', 'Add')
        : Yii::t('app', 'Edit')) .
    ' ' . Yii::t('app', 'Furniture in Italy');

?>

    <main>
        <div class="page create-sale">
            <div class="largex-container forcusttitle">

                <?= Html::tag('h1', $this->title); ?>

                <div class="column-center">
                    <div class="form-horizontal">

                        <?php $form = ActiveForm::begin([
                            'action' => ($model->isNewRecord)
                                ? Url::toRoute(['/catalog/italian-product/create'])
                                : Url::toRoute(['/catalog/italian-product/update', 'id' => $model->id]),
                            'fieldConfig' => [
                                'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
                                'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
                            ],
                        ]); ?>

                        <?php if ($model->isNewRecord) { ?>
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                <?= Yii::t('app', 'Для загрузки изображений - сначала создайте товар') ?>
                            </div>
                        <?php } else { ?>
                            <?= $form
                                ->field($model, 'image_link')
                                ->imageOne($model->getImageLink()) ?>

                            <?= $form
                                ->field($model, 'gallery_image')
                                ->imageSeveral(['initialPreview' => $model->getGalleryImage()]) ?>
                        <?php } ?>

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


                        <?= $form->field(
                            $modelLang,
                            'material',
                            ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
                        ) ?>

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

                        <?= $form->field(
                            $model,
                            'region',
                            ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
                        ) ?>

                        <?php
                        $model->phone = $model->isNewRecord ? Yii::$app->user->identity->profile->phone : '';
                        echo $form->field(
                            $model,
                            'phone',
                            ['template' => "{label}<div class=\"col-sm-2\">{input}</div>\n{hint}\n{error}"]
                        ) ?>

                        <?php
                        $model->email = $model->isNewRecord ? Yii::$app->user->identity->email : '';
                        echo $form->field(
                            $model,
                            'email',
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
                            <label class="col-sm-3 col-form-label"><?= Yii::t('app', 'Status') ?></label>
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
                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                            <?= Html::a(
                                Yii::t('app', 'Вернуться к списку'),
                                ['/catalog/italian-product/list'],
                                ['class' => 'btn btn-primary']
                            ) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </main>

<?php

$url = Url::toRoute('/catalog/factory-product/ajax-get-category');
$urlGetCities = Url::toRoute('/location/location/get-cities');

$script = <<<JS
$('#italianproduct-catalog_type_id').on('change', function () {
    $.post('$url',
        {
            _csrf: $('#token').val(),
            type_id: $(this).find('option:selected').val()
        }
    ).done(function (data) {
        var html = '';
        $.each(data.category, function( key, value ) {
           html += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#italianproduct-category_ids').html(html);
    });
});
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
