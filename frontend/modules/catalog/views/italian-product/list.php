<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\Pjax;
use kartik\grid\GridView;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    ItalianProduct, Factory
};
//
use thread\widgets\grid\{
    GridViewFilter
};

/**
 * @var \yii\data\Pagination $pages
 * @var $model \frontend\modules\catalog\models\ItalianProduct
 */

$dataProvider = $model->search(Yii::$app->request->queryParams);
$dataProvider->sort = false;

$this->title = Yii::t('app', 'Furniture in Italy');

?>

    <main>
        <div class="page category-page">
            <div class="container large-container">
                <div class="row title-cont">

                    <?= Html::tag('h1', Yii::t('app', 'Furniture in Italy')); ?>

                    <?= Html::a(
                        '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add'),
                        Url::toRoute(['/catalog/italian-product/create']),
                        ['class' => 'btn btn-goods']
                    ) ?>

                    <?= Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]) ?>

                </div>
                <div class="cat-content">
                    <div class="row">

                        <div class="col-md-12 col-lg-12">
                            <div class="cont-area cont-goods">

                                <?php Pjax::begin(['id' => 'factory-product']); ?>

                                <?= GridView::widget([
                                    'id' => 'italian-product-grid',
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $filter,
                                    'filterUrl' => Url::toRoute(['/catalog/italian-product/list']),

                                    'panel' => [
                                        'after' => Html::tag(
                                            'div',
                                            Html::button(
                                                Yii::t('app', 'Оплатить'),
                                                [
                                                    'class' => 'btn btn-success js-add-products-to-payment',
                                                ]
                                            ),
                                            [
                                                'class' => 'text-right'
                                            ]
                                        ),
                                        'before' => false,
                                        'heading' => false,
                                        'footer' => false
                                    ],
                                    'columns' => [
                                        [
                                            'format' => 'raw',
                                            'attribute' => 'image_link',
                                            'value' => function ($model) {
                                                /** @var \frontend\modules\catalog\models\ItalianProduct $model */
                                                return Html::img(
                                                    ItalianProduct::getImageThumb($model['image_link']),
                                                    ['width' => 50]
                                                );
                                            },
                                            'headerOptions' => ['class' => 'col-sm-1'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'filter' => false
                                        ],
                                        [
                                            'attribute' => 'title',
                                            'value' => 'lang.title',
                                            'label' => Yii::t('app', 'Title'),
                                        ],
                                        [
                                            'attribute' => 'factory_id',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                /** @var $model \frontend\modules\catalog\models\ItalianProduct */
                                                return ($model['factory'])
                                                    ? $model['factory']['title']
                                                    : $model['factory_name'];
                                            },
                                            'filter' => GridViewFilter::selectOne(
                                                $filter,
                                                'factory_id',
                                                Factory::dropDownList()
                                            ),
                                            'headerOptions' => ['class' => 'col-sm-2'],
                                        ],
                                        [
                                            'format' => 'raw',
                                            'attribute' => Yii::t('app', 'Status'),
                                            'value' => function ($model) {
                                                /** @var $model \frontend\modules\catalog\models\FactoryProduct */
                                                return $model->published
                                                    ? Yii::t('app', 'Published')
                                                    : Html::a(
                                                        Yii::t('app', 'Not published'),
                                                        ['/catalog/italian-product/payment'],
                                                        [
                                                            'data-method' => 'POST',
                                                            'data-params' => [
                                                                '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                                                                'id[]' => $model->id,
                                                            ],
                                                        ]
                                                    );
                                            },
                                            'headerOptions' => ['class' => 'col-sm-2'],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'class' => yii\grid\ActionColumn::class,
                                            'template' => '{update} {delete}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    /** @var $model \frontend\modules\catalog\models\ItalianProduct */
                                                    return Html::a(
                                                        '<span class="glyphicon glyphicon-pencil"></span>',
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/update', 'id' => $model->id]
                                                        ),
                                                        [
                                                            'class' => 'btn btn-default btn-xs'
                                                        ]
                                                    );
                                                },
                                                'delete' => function ($url, $model) {
                                                    /** @var $model \frontend\modules\catalog\models\ItalianProduct */
                                                    return Html::a(
                                                        '<span class="glyphicon glyphicon-trash"></span>',
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/intrash', 'id' => $model->id]
                                                        ),
                                                        [
                                                            'class' => 'btn btn-default btn-xs',
                                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                        ]
                                                    );
                                                },
                                            ],
                                            'buttonOptions' => ['class' => 'btn btn-default btn-xs'],
                                            'headerOptions' => ['class' => 'col-sm-1'],
                                        ],
                                        [
                                            'class' => kartik\grid\CheckboxColumn::class,
                                            'name' => 'id',
                                            'checkboxOptions' => function ($model) {
                                                /** @var $model \frontend\modules\catalog\models\ItalianProduct */
                                                if ($model->published) {
                                                    return ['disabled' => true];
                                                } else {
                                                    return [];
                                                }
                                            },
                                            'header' => false,
                                            'contentOptions' => ['class' => 'kv-row-select'],
                                        ]
                                    ],
                                ]); ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

<?php
$script = <<<JS

$('.js-add-products-to-payment').hide();

$('.kv-row-checkbox').on('change', function () {
    var keys = $("#italian-product-grid").yiiGridView("getSelectedRows");
    
    if (keys.length > 0) {
        $('.js-add-products-to-payment').show();
    } else {
        $('.js-add-products-to-payment').hide();
    }
});

$('.js-add-products-to-payment').on('click', function () {
    var keys = $("#italian-product-grid").yiiGridView("getSelectedRows");
    if (keys.length > 0) {
        var form = '<form action="' + baseUrl + 'italian-product/payment/" method="post">' +
        '<input type="hidden" name="_csrf" value="' + $('#token').val() + '" />';
        
        $.each(keys, function(key, value) {
            form += '<input type="hidden" name="id[]" value="'+value+'">';
        });
      
        form += '</form>';

        form = $(form);
        
        $('body').append(form);
        $(form).submit();
    }
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);