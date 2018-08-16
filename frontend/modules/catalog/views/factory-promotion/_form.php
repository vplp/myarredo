<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url, ArrayHelper
};
use yii\widgets\Pjax;
use yii\grid\GridView;
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

                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <?= Yii::t('app','Выберите товары которые хотите рекламировать') ?>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body factory-prom">

                                        <?php Pjax::begin(['id' => 'factory-product']); ?>

                                        <?= GridView::widget([
                                            'dataProvider' => $dataProviderFactoryProduct,
                                            'filterModel' => $filterModelFactoryProduct,
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
                                                            'product_ids[]',
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

                                        <?= Html::button(
                                            Yii::t('app', 'Add'),
                                            [
                                                'id' => 'add-product',
                                                'class' => 'btn btn-cancel',
                                                'data-dismiss' => 'modal'
                                            ]
                                        ) ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $form = ActiveForm::begin([
                            'id' => 'factory-promotion',
                            'action' => ($model->isNewRecord)
                                ? Url::toRoute(['/catalog/factory-promotion/create'])
                                : Url::toRoute(['/catalog/factory-promotion/update', 'id' => $model->id])
                        ]) ?>

                        <p class="reclamation-p">
                            <?= Yii::t('app','Для проведения рекламной компании вы выбрали') ?> <span id="count-products"> 0 </span>
                            <span class="for-green"> <?= Yii::t('app','товаров') ?> </span>
                        </p>

                        <?php echo Html::a(
                            Yii::t('app', 'Добавыть товары'),
                            'javascript:void(0);',
                            [
                                'class' => 'btn btn-goods big',
                                'data-toggle' => 'modal',
                                'data-target' => '#myModal'
                            ]
                        ) ?>

                        <div id="list-product">

                            <?php foreach ($model->products as $product) {
                                echo '<div>' .
                                    $product->lang->title .
                                    Html::input(
                                        'hidden',
                                        'FactoryPromotion[product_ids][]',
                                        $product->id
                                    ) .
                                    Html::img(Product::getImageThumb($product['image_link']), ['width' => 50]) .
                                    Html::a(
                                        '<i class="fa fa-times"></i></a>',
                                        null,
                                        [
                                            'id' => 'del-product',
                                            'class' => 'close',
                                            'data-id' => $product->id
                                        ]) .
                                    '</div>';
                            } ?>
                        </div>

                        <div id="factorypromotion-city_ids">
                            <?php
                            $countries = Country::findBase()->byId([2, 3])->all();
                            foreach ($countries as $country) {
                                echo '<p>' . $country['lang']['title'] . '</p>';
                                echo $form
                                    ->field($model, 'city_ids[' . $country['id'] . ']')->label(false)
                                    ->checkboxList(yii\helpers\ArrayHelper::map($country['cities'], 'id', 'lang.title'),
                                        []);
                            }
                            ?>
                        </div>

                        <?= Html::checkbox(null, false, [
                            'label' => Yii::t('app', 'Выбрать все города'),
                            'class' => 'check-all',
                        ]);
                        ?>
                    </div>

                    <?= $form
                        ->field($model, 'count_of_months')
                        ->label(Yii::t('app', 'Выберите количество месяцев'))
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
                        <?= Yii::t('app', 'Стоимость рекламной компании') ?>
                        <span id="cost"></span>
                        <span class="current-item"> <?= Yii::t('app','руб') ?> </span>
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

$promotion_id = Yii::$app->request->get('id');

$script = <<<JS

/**
 * Calculate
 */
function newCost() {
    var cost,
    count_of_months = $('input[name="FactoryPromotion[count_of_months]"]:checked').val(),
    daily_budget = $('input[name="FactoryPromotion[daily_budget]"]:checked').val(),
    count_products = $('input[name="product_ids[]"]:checked').length;
  
    cost = count_products * 1000 + count_of_months * 30 * daily_budget;

    $('input[name="FactoryPromotion[cost]"],#cost').val(cost);
    $('#cost').html(cost);
    $('#count-products').html(count_products);
}

newCost();

/**
 * Watch
 */
$('input[name="product_ids[]"], ' +
 'input[name="FactoryPromotion[daily_budget]"], ' +
  'input[name="FactoryPromotion[count_of_months]"]').on('change', function() {
     newCost();
});

/**
 * Add
 */
$('input[name="product_ids[]"]').on('change', function() {
    
    var product = $(this);
    
    $.post('/catalog/factory-promotion/ajax-add-product/',
        {
            _csrf: $('#token').val(),
            promotion_id: $promotion_id,
            catalog_item_id: $(this).val(),
        }
    ).done(function (data) {
        if (data == true) {
            
            var str = '<div>' + 
            product.data('title') + 
            '<input type="hidden" name="FactoryPromotion[product_ids][]" value="' + product.val() + '">' +
            '<img src="' + product.data('image') + '" width="50">' +
            '<a class="close"><i class="fa fa-times"></i></a>' +
            '</div>';
            
            $('#list-product').append(str);
        }
    });
});

/**
 * Delete
 */
$('a#del-product').on('click', function() {
    
    var product = $(this);
    
    $.post('/catalog/factory-promotion/ajax-del-product/',
        {
            _csrf: $('#token').val(),
            promotion_id: $promotion_id,
            catalog_item_id: product.data('id'),
        }
    ).done(function (data) {
        if (data == true) {
            
            var allCheckboxs = $('input[value="'+product.data('id')+'"');
            allCheckboxs.prop({checked: false });
            allCheckboxs.parent('.jq-checkbox').removeClass('checked');
               
            product.closest('div').remove();
        }
    });
});

/**
 * Check all
 */
$(".check-all").on('click', function() {
    var allCheckboxs = $('#factorypromotion-city_ids').find('input[type="checkbox"]');
    if ($(this).children('input[type="checkbox"]').prop('checked')) {
        allCheckboxs.prop({checked: true });
        allCheckboxs.parent('.jq-checkbox').addClass('checked');
    } else {
        allCheckboxs.prop({checked: false });
        allCheckboxs.parent('.jq-checkbox').removeClass('checked');
    }
});

function watchForCheckbox() {
    if($('#factorypromotion-city_ids').find('input[type="checkbox"]').prop("checked")) {
        $('.check-all').addClass('checked');
        $('.check-all').children('input[type="checkbox"]').prop({checked: true })
    }
} 

watchForCheckbox();

JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>