<?php

//use backend\themes\defaults\widgets\forms\ActiveForm;
use backend\app\bootstrap\ActiveForm;
//use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
//
use frontend\modules\catalog\models\{
    Category, Factory, Types, Specification, Collection
};
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\{
    ProductRelSpecification
};
use backend\modules\catalog\widgets\grid\ManyToManySpecificationValueDataColumn;
//
use backend\themes\defaults\widgets\TreeGrid;
/**
 * @var \frontend\modules\catalog\models\FactoryProduct $model
 * @var \frontend\modules\catalog\models\FactoryProductLang $modelLang
 * @var \frontend\modules\catalog\models\Specification $Specification
 */

$this->title = ($model->isNewRecord) ? Yii::t('app', 'Add') : Yii::t('app', 'Edit');

?>

    <main>
        <div class="page create-sale">
            <div class="container large-container">

                <?= Html::tag('h1', $this->title); ?>

                <div class="column-center">
                    <div class="form-horizontal">

                        <?php $form = ActiveForm::begin([
                            'action' => ($model->isNewRecord)
                                ? Url::toRoute(['/catalog/factory-product/create'])
                                : Url::toRoute(['/catalog/factory-product/update', 'id' => $model->id]),
//                        'fieldConfig' => [
//                            'template' => "{label}<div class=\"col-sm-9\">{input}</div>\n{hint}\n{error}",
//                            'labelOptions' => ['class' => 'col-sm-3 col-form-label'],
//                        ],
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

                        <?= $form->text_line($model, 'article') ?>

                        <?= $form->text_line_lang($modelLang, 'title') ?>

                        <?= $form
                            ->field($model, 'collections_id')
                            ->widget(Select2::classname(), [
                                'data' => Collection::dropDownList(['factory_id' => Yii::$app->user->identity->profile->factory_id]),
                                'options' => ['placeholder' => Yii::t('app', 'Select option')],
                            ]) ?>

                        <?= $form
                            ->field($model, 'catalog_type_id')
                            ->widget(Select2::classname(), [
                                'data' => Types::dropDownList(),
                                'options' => ['placeholder' => Yii::t('app', 'Select option')],
                            ]) ?>

                        <p>
                            Категории напрямую зависит от выбранного типа предмета.<br>
                            Если по выбраному типу предмета отсутсвует необходимая категория, зайдите в редактирование
                            категории и добавте зависимость с предметом.
                        </p>

                        <?= $form
                            ->field($model, 'category_ids')
                            ->widget(Select2::classname(), [
                                'data' => Category::dropDownList(['type_id' => $model->isNewRecord ? 0 : $model['catalog_type_id']]),
                                'options' => [
                                    'placeholder' => Yii::t('app', 'Select option'),
                                    'multiple' => true
                                ],
                            ]) ?>

                        <?= $form->field($modelLang, 'description')->textarea() ?>

                        <?= $form->field($modelLang, 'comment')->textarea() ?>

                        <?= $form->text_line($model, 'volume') ?>

                        <?php if (!$model->isNewRecord): ?>

                            <?= TreeGrid::widget([
                                'dataProvider' => (new Specification())->search(Yii::$app->request->queryParams),
                                'keyColumnName' => 'id',
                                'parentColumnName' => 'parent_id',
                                'options' => ['class' => 'table table-striped table-bordered'],
                                'columns' => [
                                    [
                                        'attribute' => 'title',
                                        'value' => 'lang.title',
                                        'label' => Yii::t('app', 'Title'),
                                    ],
                                    [
                                        'attribute' => 'val',
                                        'class' => ManyToManySpecificationValueDataColumn::class,
                                        'primaryKeyFirstTable' => 'specification_id',
                                        'attributeRow' => 'val',
                                        'primaryKeySecondTable' => 'catalog_item_id',
                                        'valueSecondTable' => Yii::$app->getRequest()->get('id'),
                                        'namespace' => ProductRelSpecification::class,
                                    ],
                                ]
                            ]); ?>

                        <?php endif; ?>

                        <?= $form->text_line($model, 'factory_price') ?>

                        <?= $form->text_line($model, 'price_from') ?>

                        <div class="buttons-cont">
                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                            <?= Html::a(Yii::t('app', 'Вернуться к списку'), ['/catalog/factory-product/list'], ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
$url = \yii\helpers\Url::toRoute('/catalog/factory-product/ajax-get-category');
$script = <<<JS
$('#factoryproduct-catalog_type_id').on('change', function () {
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
        $('#factoryproduct-category_ids').html(category);
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>