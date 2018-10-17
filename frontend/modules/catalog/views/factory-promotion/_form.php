<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url, ArrayHelper
};
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

                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <?= Yii::t('app', 'Выберите товары которые хотите рекламировать') ?>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body factory-prom">

                                        <?= GridView::widget([
                                            'dataProvider' => $dataProviderFactoryProduct,
                                            'filterModel' => $filterModelFactoryProduct,
                                            'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                                            'filterUrl' => ($model->isNewRecord)
                                                ? Url::toRoute(['/catalog/factory-promotion/create'])
                                                : Url::toRoute(['/catalog/factory-promotion/update', 'id' => $model->id]),
                                            'pjax' => true,
                                            'pjaxSettings' => [
                                                'options' => [
                                                    'enablePushState' => false,
                                                ]
                                            ],
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

                                    </div>
                                    <div class="modal-footer">

                                        <?= Html::button(
                                            Yii::t('app', 'Add'),
                                            [
                                                'id' => 'add-product',
                                                'class' => 'btn btn-goods btn-bigcenter',
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
                            <?= Yii::t('app', 'Для проведения рекламной кампании вы выбрали') ?> <span
                                    id="count-products"> 0 </span>
                            <span class="for-green"> <?= Yii::t('app', 'товаров') ?> </span>
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
                            <?php foreach ($model->products as $product) :
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
                                        "javascript:void(0);",
                                        [
                                            'id' => 'del-product',
                                            'class' => 'close',
                                            'data-id' => $product->id
                                        ]
                                    ) .
                                    '</div>';
                            endforeach; ?>
                        </div>

                        <div id="factorypromotion-city_ids">

                            <?= $form->field($model, 'country_id')
                                ->dropDownList(
                                    Country::dropDownList([2, 3]),
                                    ['class' => 'selectpicker']
                                ) ?>

                            <?php
                            $countries = Country::findBase()->byId([2, 3])->all();
                            foreach ($countries as $country) {
                                echo '<div class="tab-country-' . $country['id'] . '">';
                                echo $form
                                    ->field($model, 'city_ids[' . $country['id'] . ']')->label(false)
                                    ->checkboxList(
                                        yii\helpers\ArrayHelper::map($country['cities'], 'id', 'lang.title'),
                                        []
                                    );
                                echo '</div>';
                            }
                            ?>
                        </div>

                        <?= Html::checkbox(null, false, [
                            'label' => Yii::t('app', 'Выбрать все города'),
                            'class' => 'check-all',
                        ]) ?>

                        <?= $form
                            ->field($model, 'views')
                            ->label($model->getAttributeLabel('views'))
                            ->radioList(
                                FactoryPromotion::getCountOfViews(),
                                [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        return
                                            '<label class="reclamation-radio">' .
                                            Html::radio($name, $checked, [
                                                'value' => $value,
                                                'data-country2' => $label[2],
                                                'data-country3' => $label[3],
                                            ]) .
                                            $value .
                                            '<span class="checkmark-radio"></span>' .
                                            '</label>';
                                    },
                                ]
                            ); ?>

                        <div class="promotion-title-label">
                            <?= Yii::t('app', 'Стоимость размещения товара в рекламе') ?>
                            <span id="cost_products">0</span>
                            <span class="current-item"> <?= Yii::t('app', 'руб') ?> </span>
                        </div>
                        <div class="promotion-title-label">
                            <?= Yii::t('app', 'Стоимость размещения рекламы в поиске') ?>
                            <span id="cost_of_views">0</span>
                            <span class="current-item"> <?= Yii::t('app', 'руб') ?> </span>
                        </div>
                        <div class="promotion-title-label">
                            <?= Yii::t('app', 'Общая стоимость рекламной кампании') ?>
                            <span id="cost">0</span>
                            <span class="current-item"> <?= Yii::t('app', 'руб') ?> </span>
                            <span class="for-nds">(* <?= Yii::t('app', 'цены указаны без НДС') ?>)</span>
                        </div>
                        <div class="promotion-title-label for-hide">
                            <?= Yii::t('app', 'НДС 19%') ?>
                            <span id="nds_count">0</span>
                            <span class="current-item"> <?= Yii::t('app', 'руб') ?> </span>
                        </div>
                        <div class="promotion-title-label for-hide">
                            <?= Yii::t('app', 'Стоимость рекламной кампании с НДС') ?>
                            <span id="total_nds">0</span>
                            <span class="current-item"> <?= Yii::t('app', 'руб') ?> </span>
                        </div>

                        <?= $form->field($model, 'amount')
                            ->label(false)
                            ->input('hidden') ?>

                        <?= $form->field($model, 'amount_with_vat')
                            ->label(false)
                            ->input('hidden') ?>

                        <div class="buttons-cont">
                            <?= Html::submitButton(
                                Yii::t('app', 'Сохранить кампанию'),
                                ['class' => 'btn btn-goods']
                            ) ?>

                            <?= Html::submitButton(
                                Yii::t('app', 'Оплатить'),
                                ['class' => 'btn btn-goods', 'name' => 'payment', 'value' => 1]
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

$promotion_id = Yii::$app->request->get('id') ?? 0;

$script = <<<JS
// js for display cities when change select
$('#factorypromotion-city_ids').find('#factorypromotion-country_id').on('change', function(etg) {
    var rusBoxTab = $(this).closest('#factorypromotion-city_ids').children('.tab-country-2');
    var belBoxTab = $(this).closest('#factorypromotion-city_ids').children('.tab-country-3');
    
    if ($(this).val() === "2") {
        rusBoxTab.find('input[type="checkbox"]').prop('checked', false).parent('.jq-checkbox').removeClass('checked');
        belBoxTab.find('input[type="checkbox"]').prop('checked', false).parent('.jq-checkbox').removeClass('checked');
        rusBoxTab.css('display', 'block');
        belBoxTab.css('display', 'none');
        $('.check-all').removeClass('checked').children('input[type="checkbox"]').prop('checked', false);
    } else if ($(this).val() === "3") {
        rusBoxTab.find('input[type="checkbox"]').prop('checked', false).parent('.jq-checkbox').removeClass('checked');
        belBoxTab.find('input[type="checkbox"]').prop('checked', false).parent('.jq-checkbox').removeClass('checked');
        rusBoxTab.css('display', 'none');
        belBoxTab.css('display', 'block');
        $('.check-all').removeClass('checked').children('input[type="checkbox"]').prop('checked', false);
    }
    
    newCost();
});

function watchForSelect() {
    var ourVal = $('#factorypromotion-city_ids').find('#factorypromotion-country_id');
    var rusBoxTab = $('#factorypromotion-city_ids').children('.tab-country-2');
    var belBoxTab = $('#factorypromotion-city_ids').children('.tab-country-3');
    
    if (ourVal.val() === "2") {
        rusBoxTab.css('display', 'block');
        belBoxTab.css('display', 'none');
    } else if (ourVal.val() === "3") {
        rusBoxTab.css('display', 'none');
        belBoxTab.css('display', 'block');
    }
}

watchForSelect();

// js for reinit plugin styler when used search in popup
$('.factory-prom').on('blur', 'input[type="text"]', function() {
    setTimeout(function() {
        $('.factory-prom').find('input[type="checkbox"]').styler();
    },1000);
});

// js for functional for checkbox checked all 
$("body").on("change", ".check-all", function() {
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

/**
 * Calculate
 */
function newCost() {
    var selectedCountry = $('#factorypromotion-city_ids').find('#factorypromotion-country_id').val();   
    var cost, 
    cost_of_views = 0, numberViews, cost_products,
    numberViews = parseInt($('input[name="FactoryPromotion[views]"]:checked').val()),
    count_products = $('input[name="product_ids[]"]:checked').length;
    var nds = 0;
    var totalNds = 0;

    if (selectedCountry === "2") {
        switch (numberViews) {
            case 1000:
            cost_of_views = 24000;
            break;
            case 1400:
            cost_of_views = 32000;
            break;
            case 1900:
            cost_of_views = 40000;
            break;
            case 2500:
            cost_of_views = 48000;
            break;
            case 3100:
            cost_of_views = 56000;
            break;
            case 3600:
            cost_of_views = 64000;
            break;
            case 4200:
            cost_of_views = 72000;
            break;
            case 5000:
            cost_of_views = 80000;
            break;
            default:
            cost_of_views = 0;
        }  
    } else if (selectedCountry === "3") {
        switch (numberViews) {
            case 1000:
            cost_of_views = 20400;
            break;
            case 1400:
            cost_of_views = 27200;
            break;
            case 1900:
            cost_of_views = 34000;
            break;
            case 2500:
            cost_of_views = 40800;
            break;
            case 3100:
            cost_of_views = 47600;
            break;
            case 3600:
            cost_of_views = 54400;
            break;
            case 4200:
            cost_of_views = 61200;
            break;
            case 5000:
            cost_of_views = 68000;
            break;
            default:
            cost_of_views = 0;
        }
    }

    cost_products = count_products * 1000;
    cost = cost_products + cost_of_views;
    nds = (cost * 19) / 100;
    totalNds = cost + nds;

    $('input[name="FactoryPromotion[amount]"],#cost').val(cost);
    $('#cost').html(cost);
    $('#cost_of_views').html(cost_of_views);
    $('#cost_products').html(cost_products);
    $('#count-products').html(count_products);
    $('#nds_count').html(nds);
    $('#total_nds').html(totalNds);
    $('input[name="FactoryPromotion[amount_with_vat]"]').val(totalNds);
}

newCost();

/**
 * Watch
 */
$('input[name="FactoryPromotion[views]"]').on('change', function() {
     newCost();
});

/**
 * Add
 */
$("body").on("click", "#add-product", function() {
    var str = "";
    var product = "";
    var issetProduct = [];
   
    $('input[name="product_ids[]"]:checkbox:checked').each(function () {
        var indicator = "no";
        product = $(this);
        $('#factory-promotion').find('#list-product').find('.close').each(function(i, elem) {
            issetProduct.push($(elem).attr('data-id'));
        });
        for (var i = 0; i < issetProduct.length; i++) {
            if (product.val() === issetProduct[i]) {
                indicator = "yes";
            }
        }
        if (indicator !== "yes") {
            str += '<div>' + 
                    product.data('title') + 
                    '<input type="hidden" name="FactoryPromotion[product_ids][]" value="' + product.val() + '">' +
                    '<img src="' + product.data('image') + '" width="50">' +
                    '<a id="del-product" class="close" href="javascript:void(0);" data-id="' + product.val() + '"><i class="fa fa-times"></i></a>' +
                    '</div>';
        }
    });
   
    $('#list-product').append(str);
    
    newCost();
});

/**
 * Delete
 */
$("body").on("click", "#del-product", function() {
    var product = $(this);
 
    var allCheckboxs = $('input[value="'+product.data('id')+'"');
    allCheckboxs.prop({checked: false });
    allCheckboxs.parent('.jq-checkbox').removeClass('checked');
     
    product.closest('div').remove();
    
     newCost();
});

/**
 * Check all
 */
function urlParam(name) {
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results[1] || 0;
}

var product_id = parseInt(urlParam('product_id'));

if (product_id) {
    $('input[name="product_ids[]"][value='+product_id+']').prop("checked",true);
   
    var product = $('input[name="product_ids[]"][value='+product_id+']');

    product.prop({checked: true });
    product.parent('.jq-checkbox').addClass('checked');
   
    var str = '<div>' + 
            product.data('title') + 
            '<input type="hidden" name="FactoryPromotion[product_ids][]" value="' + product.val() + '">' +
            '<img src="' + product.data('image') + '" width="50">' +
            '<a id="del-product" class="close" href="javascript:void(0);" data-id="' + product.val() + '"><i class="fa fa-times"></i></a>' +
            '</div>';
   
    $('#list-product').html(str);
   
    newCost();
}
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>