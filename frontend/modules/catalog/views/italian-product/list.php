<?php

use yii\helpers\{ArrayHelper, Html, Url};
use yii\data\Pagination;
use yii\widgets\Pjax;
use kartik\grid\GridView;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    ItalianProduct, Factory
};

/**
 * @var $pages Pagination
 * @var $model ItalianProduct
 * @var $filter ItalianProduct
 */
$queryParams['defaultPageSize'] = 9999;
$dataProvider = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));
$dataProvider->sort = false;

$this->title = Yii::t('app', 'Furniture in Italy');

?>

    <main>
        <div class="page category-page">
            <div class="largex-container itprod-box">
                <div class="row title-cont">


                    <?= Html::tag('h1', Yii::t('app', 'Furniture in Italy')); ?>
                    <div class="itprod-panel-add">
                        <?= Html::a(
                            '<i class="fa fa-list"></i> ' . Yii::t('app', 'Активные'),
                            null,
                            ['class' => 'btn']
                        ) ?>

                        <?= Html::a(
                            '<i class="fa fa-outdent"></i> ' . Yii::t('app', 'Завершенные'),
                            Url::toRoute(['/catalog/italian-product/completed']),
                            ['class' => 'btn']
                        ) ?>

                        <?= Html::a(
                            '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Paid add'),
                            Url::toRoute(['/catalog/italian-product/paid-create']),
                            ['class' => 'btn btn-goods']
                        ) ?>

                        <?= Html::a(
                            '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Free add'),
                            Url::toRoute(['/catalog/italian-product/free-create']),
                            ['class' => 'btn btn-goods']
                        ) ?>
                    </div>

                    <?= Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]) ?>

                </div>
                <div class="cat-content">
                    <div class="row">

                        <div class="col-md-12 col-lg-12">
                            <div class="cont-area cont-goods">

                                <?php Pjax::begin(['id' => 'factory-product']); ?>

                                <?php
                                $pCount = $fCount = $pCost = $fCost = 0;
                                foreach ($dataProvider->getModels() as $model) {
                                    if ($model->create_mode == 'paid') {
                                        ++$pCount;
                                        $pCost = $pCost + ItalianProduct::getCostPlacementProduct()['amount'];
                                    } else {
                                        ++$fCount;
                                        $fCost = $fCost + ItalianProduct::getFreeCostPlacementProduct($model);
                                    }
                                }

                                echo "<p>Размещено товаров: $pCount (платно - $pCost RUB); $fCount (22% - $fCost RUB)</p>";
                                ?>

                                <?= GridView::widget([
                                    'id' => 'italian-product-grid',
                                    'dataProvider' => $dataProvider,
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
                                                /** @var $model ItalianProduct */
                                                return
                                                    Html::a(
                                                        Html::img(
                                                            ItalianProduct::getImageThumb($model['image_link']),
                                                            ['width' => 50]
                                                        ),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/update', 'id' => $model->id]
                                                        )
                                                    );
                                            },
                                            'headerOptions' => ['class' => 'col-sm-1'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'filter' => false
                                        ],
                                        [
                                            'format' => 'raw',
                                            'attribute' => 'title',
                                            'filter' => false,
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */
                                                return
                                                    Html::a(
                                                        $model['lang']['title'],
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/update', 'id' => $model->id]
                                                        ),
                                                        ['class' => 'prodname']
                                                    );
                                            },
                                            'label' => Yii::t('app', 'Title'),
                                        ],
                                        // [
                                        //     'attribute' => 'factory_id',
                                        //     'format' => 'raw',
                                        //     'value' => function ($model) {
                                        //         /** @var $model ItalianProduct */
                                        //         return ($model['factory'])
                                        //             ? $model['factory']['title']
                                        //             : $model['factory_name'];
                                        //     },
                                        //     'filter' => false,
                                        //     'headerOptions' => ['class' => 'col-sm-2'],
                                        // ],
                                        [
                                            'attribute' => 'price_new',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */
                                                return $model['price_new'] . ' ' . $model['currency'];
                                            },
                                            'filter' => false,
                                            'headerOptions' => ['class' => 'col-sm-2'],
                                        ],
                                        [
                                            'attribute' => 'create_mode',
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */
                                                return ItalianProduct::createModeRange($model->create_mode);
                                            },
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Количество просмотров'),
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */
                                                return Html::tag('span', $model->getCountViews(), ['class' => 'viewscount']);
                                            },
                                        ],
                                        [
                                            'format' => 'raw',
                                            'label' => Yii::t('app', 'Количество запросов'),
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */
                                                return Html::tag('span', $model->getCountRequests(), ['class' => 'requestcount']);
                                            },
                                        ],
                                        [
                                            'format' => 'raw',
                                            'attribute' => Yii::t('app', 'Status'),
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */

                                                if ($model->is_sold) {
                                                    $status = Yii::t('app', 'Item sold');
                                                } elseif ($model->payment &&
                                                    $model->payment->payment_status == 'success' &&
                                                    $model->create_mode == 'paid' &&
                                                    $model->published == 0) {
                                                    $status = Yii::t('app', 'На модерации');
                                                } elseif ($model->status == 'on_moderation' &&
                                                    $model->published == 0) {
                                                    $status = Yii::t('app', 'На модерации');
                                                } elseif ($model->published == 1) {
                                                    $status = Html::tag(
                                                            'div',
                                                            Html::tag(
                                                                'div',
                                                                '',
                                                                [
                                                                    'class' => 'progressbar',
                                                                    'style' => 'width:' . (100 * $model->getDiffPublishedDate() / 60) . '%',
                                                                ]
                                                            ),
                                                            [
                                                                'class' => 'progressbox',
                                                                'title' => (100 * $model->getDiffPublishedDate() / 60) . '%'
                                                            ]
                                                        )
                                                        .
                                                        Html::tag(
                                                            'span',
                                                            Yii::t('app', 'Осталось дней') . ' - ' . $model->getDiffPublishedDate(),
                                                            ['class' => 'progresssubtitle']
                                                        );
                                                } else if ($model->create_mode == 'paid') {
                                                    $status = Html::a(
                                                        Yii::t('app', 'Опубликовать'),
                                                        ['/catalog/italian-product/payment'],
                                                        [
                                                            'data-method' => 'GET',
                                                            'data-params' => [
                                                                '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                                                                'id[]' => $model->id,
                                                            ],
                                                            'class' => 'btn-puplished btn-xs'
                                                        ]
                                                    );
                                                } elseif ($model->create_mode == 'free') {
                                                    $status = Html::a(
                                                        Yii::t('app', 'Опубликовать'),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/on-moderation', 'id' => $model->id]
                                                        ),
                                                        ['class' => 'btn-puplished btn-xs']
                                                    );
                                                } else {
                                                    $status = '';
                                                }

                                                return $status;
                                            },
                                            'headerOptions' => ['class' => 'col-sm-2'],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'class' => yii\grid\ActionColumn::class,
                                            'template' => '{update} {delete}{sold}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    /** @var $model ItalianProduct */
                                                    return Html::a(
                                                        '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Edit'),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/update', 'id' => $model->id]
                                                        ),
                                                        [
                                                            'class' => 'btn btn-default btn-xs'
                                                        ]
                                                    );
                                                },
                                                'delete' => function ($url, $model) {
                                                    /** @var $model ItalianProduct */
                                                    return Html::a(
                                                        '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('app', 'Delete'),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/intrash', 'id' => $model->id]
                                                        ),
                                                        [
                                                            'class' => 'btn btn-default btn-xs',
                                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                        ]
                                                    );
                                                },
                                                'sold' => function ($url, $model) {
                                                    /** @var $model ItalianProduct */
                                                    return Html::a(
                                                        '<span class="glyphicon glyphicon-shopping-cart"></span> ' . Yii::t('app', 'Item sold'),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product/is-sold', 'id' => $model->id]
                                                        ),
                                                        [
                                                            'class' => 'btn btn-default btn-xs',
                                                            'data-confirm' => Yii::t('yii', 'Are you sure?'),
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
                                                /** @var $model ItalianProduct */
                                                if ($model->create_mode == 'free' || $model->published) {
                                                    return ['disabled' => true];
                                                } else {
                                                    return [];
                                                }
                                            },
                                            'header' => Yii::t('app', 'Select'),
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
        var form = '<form action="' + baseUrl + 'italian-product/payment/" method="get">' +
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

$this->registerJs($script);