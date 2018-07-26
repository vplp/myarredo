<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url, ArrayHelper
};
use yii\widgets\Pjax;
use kartik\grid\GridView;
//
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\{
    FactoryPromotion, Product, FactoryProduct, FactoryPromotionRelProduct
};

/**
 * @var \frontend\modules\catalog\models\FactoryPromotion $model
 * @var \frontend\modules\catalog\models\FactoryProduct $modelProduct
 */

$this->title = Yii::t('app', 'Рекламировать');

?>

    <main>
        <div class="page create-sale page-reclamations">
            <div class="largex-container">

                <?= Html::tag('h1', $this->title); ?>

                <div class="column-center">
                    <div class="form-horizontal">

                        <?php $form = ActiveForm::begin([
                            'action' => ($model->isNewRecord)
                                ? Url::toRoute(['/catalog/factory-promotion/create'])
                                : Url::toRoute(['/catalog/factory-promotion/update', 'id' => $model->id]),
                        ]) ?>

                        <p class="reclamation-p">Для проведения рекламной компании вы выбрали <span id="count-products"> 0 </span> <span class="for-green"> товаров </span></p>
                        <?php echo Html::a(
                            Yii::t('app', 'Добавыть товары'),
                            'javascript:void(0);',
                            [
                                'class' => 'btn btn-goods big',
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

                                        <?php Pjax::begin(['id' => 'factory-promotion-form']); ?>

                                        <?php

                                        $dataProvider = $modelProduct->search(ArrayHelper::merge(Yii::$app->request->queryParams, ['pagination' => false]));
                                        $dataProvider->sort = false;

                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $modelProduct,
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
                                                    'format' => 'raw'
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

                                                        $checked = FactoryPromotionRelProduct::findBase()
                                                            ->where([
                                                                'promotion_id' => Yii::$app->request->get('id'),
                                                                'catalog_item_id' => $model->id,
                                                            ])
                                                            ->one();

                                                        return Html::checkbox(
                                                            'FactoryPromotion[product_ids][]',
                                                            $checked,
                                                            [
                                                                'value' => $model->id,
                                                                'data-title' => $model->lang->title,
                                                                'data-image' => Product::getImageThumb($model['image_link']),
                                                                'data-article' => $model->article,
                                                            ]
                                                        );
                                                    },
                                                ],
                                            ],
                                        ]) ?>

                                        <?php Pjax::end(); ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                id="add-product"
                                                class="btn btn-cancel"
                                                data-dismiss="modal"><?= Yii::t('app', 'Add') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="list-product"></div>

                        <?= $form
                            ->field($model, 'city_ids')
                            ->label(Yii::t('app', 'Выберите города в которых хотите провести рекламную компанию'))
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
                            ->label(Yii::t('app', 'Выберите количество месяцев'))
                            //->radioList(FactoryPromotion::getCountOfMonthsRange(), [])
                            ->radioList(
                                FactoryPromotion::getCountOfMonthsRange(),
                                [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        return
                                            '<label class="reclamation-radio">' .
                                            Html::radio($name, $checked, ['value' => $value]) .
                                            $label .
                                            '<span class="checkmark-radio"></span>' .
                                            '</label>';
                                    },
                                ]
                            )
                        ?>

                        <?= $form
                            ->field($model, 'daily_budget')
                            ->label(Yii::t('app', 'Выберите дневной бюджет'))
                            //->radioList(FactoryPromotion::getDailyBudgetRange(), [])
                            ->radioList(
                                FactoryPromotion::getDailyBudgetRange(),
                                [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        return
                                            '<label class="reclamation-radio">' .
                                            Html::radio($name, $checked, ['value' => $value]) .
                                            $label .
                                            '<span class="checkmark-radio"></span>' .
                                            '</label>';
                                    },
                                ]
                            )
                        ?>

                        <div class="promotion-title-label">
                            <?= Yii::t('app', 'Стоимость рекламной компании') ?> <span id="cost"></span> <span class="current-item"> руб </span>
                        </div>

                        <?= $form->field($model, 'cost')
                            ->label(false)
                            ->input('hidden') ?>

                        <div class="buttons-cont">
                            <?= Html::submitButton(
                                Yii::t('app', 'Сохранить компанию'),
                                ['class' => 'btn btn-goods']
                            ) ?>

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
function newCost() {
    var cost,
    count_of_months = $('input[name="FactoryPromotion[count_of_months]"]:checked').val(),
    daily_budget = $('input[name="FactoryPromotion[daily_budget]"]:checked').val(),
    count_products = $('input[name="FactoryPromotion[product_ids][]"]:checked').length;
  
    cost = count_products * 1000 + count_of_months * 30 * daily_budget;

    $('input[name="FactoryPromotion[cost]"],#cost').val(cost);
    $('#cost').html(cost);
    $('#count-products').html(count_products);
}

function showProduct() {
    var str = '';
    
    $('#list-product').html('');
    
    $('input[name="FactoryPromotion[product_ids][]"]:checked').each(function () {
        console.log($(this).val());
        str += '<div>' + 
        $(this).data('title') + 
        $(this).data('article') + 
        '<img src="'+ $(this).data('image') + '" width="100">' +
        '<span class="close"> <i class="fa fa-times"></i> </span>' +
        '</div>';
    });
    
    $('#list-product').append(str);
}

showProduct();
newCost();

$('input[name="FactoryPromotion[product_ids][]"], ' +
 'input[name="FactoryPromotion[daily_budget]"], ' +
  'input[name="FactoryPromotion[count_of_months]"]').on('change', function() {
     newCost();
});

$('#add-product').on('click', function() {
     showProduct();
});

JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>