<?php

//use backend\themes\defaults\widgets\forms\ActiveForm;
use yii\widgets\ActiveForm;
//use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\grid\GridView;
use kartik\widgets\Select2;
//
use frontend\modules\catalog\models\{
    Category, Factory, Types, Specification, Collection
};
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\{
    FactoryPromotion, Product, FactoryProduct
};
use backend\modules\catalog\widgets\grid\ManyToManySpecificationValueDataColumn;
//
use backend\themes\defaults\widgets\TreeGrid;
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};

/**
 * @var \frontend\modules\catalog\models\FactoryPromotion $model
 */

$this->title = Yii::t('app', 'Рекламировать');

?>

    <main>
        <div class="page create-sale">
            <div class="container large-container">

                <?= Html::tag('h1', $this->title); ?>

                <div class="column-center">
                    <div class="form-horizontal">

                        <?php $form = ActiveForm::begin([
                            'action' => ($model->isNewRecord)
                                ? Url::toRoute(['/catalog/factory-promotion/create'])
                                : Url::toRoute(['/catalog/factory-promotion/update', 'id' => $model->id]),
                        ]); ?>

                        <?php echo Html::a(
                            Yii::t('app', 'Add'),
                            'javascript:void(0);',
                            [
                                'class' => 'btn btn-default big',
                                'data-toggle' => 'modal',
                                'data-target' => '#myModal'
                            ]
                        ) ?>

                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Выберите товары которые хотите рекламировать
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        xxx
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-cancel"
                                                data-dismiss="modal"><?= Yii::t('app', 'Add') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?= GridView::widget([
                            'dataProvider' => $modelProduct->search(Yii::$app->request->queryParams),
                            'filterModel' => $modelProduct->load(Yii::$app->getRequest()->queryParams),
                            'pjax' => true,
                            'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                            'columns' => [
                                [
                                    'attribute' => 'article',
                                    'value' => 'article',
                                    'headerOptions' => ['class' => 'col-sm-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'image_link',
                                    'value' => function ($model) {
                                        /** @var \frontend\modules\catalog\models\FactoryProduct $model */
                                        return Html::img(Product::getImageThumb($model['image_link']), ['width' => 50]);
                                    },
                                    'headerOptions' => ['class' => 'col-sm-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'raw',
                                    'filter' => false
                                ],
                                [
                                    'attribute' => 'title',
                                    'value' => 'lang.title',
                                    'label' => Yii::t('app', 'Title'),
                                ],
                                [
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        /** @var \frontend\modules\catalog\models\FactoryProduct $model */
                                        return Html::checkbox( 'FactoryPromotion[product_ids][]', false, ['value' => $model->id]);
                                    },
                                ]
                            ],
                        ]) ?>

                        <?= $form
                            ->field($model, 'city_ids')
                            ->checkboxList(City::dropDownList())
                        //                        ->widget(Select2::classname(), [
                        //                            'data' => Types::dropDownList(),
                        //                            'options' => [
                        //                                'placeholder' => Yii::t('app', 'Select option'),
                        //                                'multiple' => true
                        //                            ],
                        //                        ])
                        ?>

                        <?= $form
                            ->field($model, 'count_of_months')
                            ->radioList(FactoryPromotion::getCountOfMonthsRange(), [])
                        //                        ->radioList(
                        //                            FactoryPromotion::getCountOfMonthsRange(),
                        //                            [
                        //                                'item' => function ($index, $label, $name, $checked, $value) {
                        //                                    return
                        //                                        '<div class="radio-e">' .
                        //                                        Html::radio($name, $checked, ['value' => $value]) .
                        //                                        Html::label('<span></span>' . $label) .
                        //                                        '</div>';
                        //                                },
                        //                            ]
                        //                        )
                        ?>

                        <?= $form
                            ->field($model, 'daily_budget')
                            ->radioList(FactoryPromotion::getDailyBudgetRange(), [])
                        //                        ->radioList(
                        //                            FactoryPromotion::getDailyBudgetRange(),
                        //                            [
                        //                                'item' => function ($index, $label, $name, $checked, $value) {
                        //                                    return
                        //                                        '<div class="radio-e">' .
                        //                                        Html::radio($name, $checked, ['value' => $value]) .
                        //                                        Html::label('<span></span>' . $label) .
                        //                                        '</div>';
                        //                                },
                        //                            ]
                        //                        )
                        ?>

                        <?= $form->field($model, 'cost') ?>

                        <div class="buttons-cont">
                            <?= Html::submitButton(
                                Yii::t('app', 'Оплатить'),
                                ['class' => 'btn btn-goods']
                            ) ?>

                            <?= Html::a(
                                Yii::t('app', 'Вернуться к списку'),
                                ['/catalog/factory-promotion/list'],
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

$script = <<<JS
function cost() {
    
    var cost,
    count_of_months = $('input[name="FactoryPromotion[count_of_months]"]:checked').val(),
    daily_budget = $('input[name="FactoryPromotion[daily_budget]"]:checked').val();
    
    cost = count_of_months * 30 * daily_budget;

    $('input[name="FactoryPromotion[cost]"]').val(cost);
}

cost();

$('input[type=radio]').on('change', function() {
     cost();
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>