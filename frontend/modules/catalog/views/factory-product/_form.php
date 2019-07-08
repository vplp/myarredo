<?php

use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
//
use frontend\modules\catalog\models\{
    Category, Types, Specification, Collection
};
use frontend\modules\catalog\models\{
    ProductRelSpecification
};
use backend\app\bootstrap\ActiveForm;
use backend\widgets\TreeGrid;
use backend\modules\catalog\widgets\grid\ManyToManySpecificationValueDataColumn;

/**
 * @var \frontend\modules\catalog\models\FactoryProduct $model
 * @var \frontend\modules\catalog\models\FactoryProductLang $modelLang
 * @var \frontend\modules\catalog\models\Specification $Specification
 */

$this->title = ($model->isNewRecord)
    ? Yii::t('app', 'Add')
    : Yii::t('app', 'Edit');

?>

    <main>
        <div class="page create-sale factory-product">
            <div class="container large-container">

                <?= Html::tag('h1', $this->title); ?>

                <div class="column-center">
                    <div class="form-horizontal">

                        <?php $form = ActiveForm::begin([
                            'action' => ($model->isNewRecord)
                                ? Url::toRoute(['/catalog/factory-product/create'])
                                : Url::toRoute(['/catalog/factory-product/update', 'id' => $model->id]),
                        ]); ?>

                        <?php if (!$model->isNewRecord) { ?>
                            <?= $form
                                ->field($model, 'image_link')
                                ->imageOne($model->getImageLink()) ?>
                            <?= $form
                                ->field($model, 'gallery_image')
                                ->imageSeveral(['initialPreview' => $model->getGalleryImage()]) ?>
                        <?php } ?>

                        <?= $form->text_line($model, 'article') ?>

                        <?= $form
                            ->field($model, 'collections_id')
                            ->widget(Select2::class, [
                                'data' => Collection::dropDownList([
                                    'factory_id' => Yii::$app->user->identity->profile->factory_id
                                ]),
                                'options' => ['placeholder' => Yii::t('app', 'Select option')],
                            ]) ?>

                        <?= Html::a(
                            '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create collection'),
                            Url::toRoute(['/catalog/factory-collections/create']),
                            ['class' => 'btn btn-goods', 'target' => '_blank']
                        ) ?>

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

                        <?= $form->field($modelLang, 'comment')->textarea() ?>

                        <?= $form->text_line($model, 'volume') ?>

                        <?php
                        if (!$model->isNewRecord) {
                            echo TreeGrid::widget([
                                'dataProvider' => (new Specification())->search(Yii::$app->request->queryParams),
                                'keyColumnName' => 'id',
                                'parentColumnName' => 'parent_id',
                                'options' => ['class' => 'table table-striped table-bordered'],
                                'columns' => [
                                    [
                                        'attribute' => 'title',
                                        'value' => 'lang.title',
                                        'label' => false,
                                    ],
                                    [
                                        'attribute' => 'val',
                                        'label' => Yii::t('app', 'Select'),
                                        'class' => ManyToManySpecificationValueDataColumn::class,
                                        'primaryKeyFirstTable' => 'specification_id',
                                        'attributeRow' => 'val',
                                        'primaryKeySecondTable' => 'catalog_item_id',
                                        'valueSecondTable' => Yii::$app->getRequest()->get('id'),
                                        'namespace' => ProductRelSpecification::class,
                                    ],
                                ]
                            ]);
                        } ?>

                        <?= $form->text_line($model, 'factory_price') ?>

                        <div class="buttons-cont">
                            <?= Html::submitButton(
                                Yii::t('app', 'Save'),
                                ['class' => 'btn btn-goods']
                            ) ?>

                            <?= Html::a(
                                Yii::t('app', 'Вернуться к списку'),
                                ['/catalog/factory-product/list'],
                                ['class' => 'btn btn-cancel']
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
$script = <<<JS
$('#factoryproduct-catalog_type_id').on('change', function () {
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
        $('#factoryproduct-category_ids').html(html);
    });
});
JS;

$this->registerJs($script);
