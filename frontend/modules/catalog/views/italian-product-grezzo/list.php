<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    ItalianProduct, Factory
};

/**
 * @var $pages Pagination
 * @var $model ItalianProduct
 * @var $filter ItalianProduct
 */

$dataProvider = $model->search(Yii::$app->request->queryParams);
$dataProvider->sort = false;

$this->title = $this->context->title;

?>
<style>
    .category-page .cat-prod .one-prod-tile .background,
    .std-slider .background{
        -webkit-filter: none;
        filter: none;
    }
</style>
    <main>
        <div class="page category-page">
            <div class="largex-container itprod-box">
                <div class="row title-cont">


                    <?= Html::tag('h1', $this->title); ?>
                    <div class="itprod-panel-add">
                        <?= Html::a(
                            '<i class="fa fa-list"></i> ' . Yii::t('app', 'Активные'),
                            null,
                            ['class' => 'btn']
                        ) ?>
                        <?= Html::a(
                            '<i class="fa fa-outdent"></i> ' . Yii::t('app', 'Завершенные'),
                            Url::toRoute(['/catalog/italian-product-grezzo/completed']),
                            ['class' => 'btn']
                        ) ?>
                        <?= Html::a(
                            '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Free add'),
                            Url::toRoute(['/catalog/italian-product-grezzo/free-create']),
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

                                <?= GridView::widget([
                                    'id' => 'italian-product-grid',
                                    'dataProvider' => $dataProvider,
                                    'filterUrl' => Url::toRoute(['/catalog/italian-product-grezzo/list']),
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
                                        'heading' => false
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
                                                            ['width' => 200]
                                                        ),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product-grezzo/update', 'id' => $model->id]
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
                                                            ['/catalog/italian-product-grezzo/update', 'id' => $model->id]
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
                                            'label' => Yii::t('app', 'Price'),
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
                                            'label' => Yii::t('app', 'Amount to pay'),
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */
                                                if (isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id != 4) {
                                                    $modelCostProduct = ItalianProduct::getCostPlacementProduct(1, true);
                                                } elseif ($model->create_mode == 'paid') {
                                                    $modelCostProduct = ItalianProduct::getCostPlacementProduct(1, true);
                                                } elseif ($model->create_mode == 'free') {
                                                    $modelCostProduct = ItalianProduct::getFreeCostPlacementProduct($model, true);
                                                }

                                                return $modelCostProduct['amount'] . ' ' . $modelCostProduct['currency'];
                                            },
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Количество просмотров'),
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */
                                                return ($model->published && $model->getCountViews() > 0)
                                                    ? Html::a(
                                                        Html::tag('span', $model->getCountViews(), ['class' => 'viewscount']),
                                                        Url::toRoute([
                                                            '/catalog/sale-italy-stats/view',
                                                            'id' => $model['id']
                                                        ])
                                                    )
                                                    : Html::tag('span', $model->getCountViews(), ['class' => 'viewscount']);
                                            },
                                        ],
                                        [
                                            'format' => 'raw',
                                            'label' => Yii::t('app', 'Количество запросов'),
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */
                                                return ($model->published && $model->getCountRequests() > 0)
                                                    ? Html::a(
                                                        Html::tag('span', $model->getCountRequests(), ['class' => 'requestcount']),
                                                        Url::toRoute([
                                                            '/catalog/sale-italy-stats/view',
                                                            'id' => $model['id']
                                                        ])
                                                    )
                                                    : Html::tag('span', $model->getCountRequests(), ['class' => 'requestcount']);
                                            },
                                        ],
                                        [
                                            'format' => 'raw',
                                            'attribute' => Yii::t('app', 'Status'),
                                            'value' => function ($model) {
                                                /** @var $model ItalianProduct */

                                                if ($model->is_sold) {
                                                    $status = Html::tag('div', Yii::t('app', 'Item sold'));
                                                } elseif ($model->payment && $model->payment->payment_status == 'success' && $model->create_mode == 'paid' && $model->published == 0) {
                                                    $status = Html::tag('div', Yii::t('app', 'На модерации'));
                                                } elseif ($model->status == 'on_moderation' && $model->published == 0) {
                                                    $status = Html::tag('div', Yii::t('app', 'На модерации'));
                                                } elseif ($model->published == 1 && $model->create_mode == 'paid') {
                                                    $status = Html::tag('div', Yii::t('app', 'Оплачено'))
                                                        .
                                                        Html::tag(
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
                                                } elseif ($model->published == 1 && $model->create_mode == 'free') {
                                                    $status = '';

                                                    if (!$model->payment || $model->payment->payment_status != 'success') {
                                                        $status .= Html::tag('div', Yii::t('app', 'Долг') . ':' . ItalianProduct::getFreeCostPlacementProduct($model, true)['amount']) .
                                                            Html::a(
                                                                Yii::t('app', 'Оплатить'),
                                                                ['/catalog/italian-product-grezzo/interest-payment', 'id' => $model->id],
                                                                [
                                                                    'class' => 'btn-puplished btn-xs',
                                                                    'style' => 'margin:5px 0;'
                                                                ]
                                                            );
                                                    }

                                                    $status .= Html::tag(
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
                                                        ['/catalog/italian-product-grezzo/payment'],
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
                                                            ['/catalog/italian-product-grezzo/on-moderation', 'id' => $model->id]
                                                        ),
                                                        ['class' => 'btn-puplished btn-xs']
                                                    );
                                                } else {
                                                    $status = '';
                                                }

                                                if ($model->create_mode == 'free') {
                                                    $status .= Html::a(
                                                        Yii::t('app', 'Оплатить'),
                                                        ['/catalog/italian-product-grezzo/payment'],
                                                        [
                                                            'data-method' => 'GET',
                                                            'data-params' => [
                                                                '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                                                                'id[]' => $model->id,
                                                                'change_tariff' => 1,
                                                            ],
                                                            'class' => 'btn-puplished btn-xs'
                                                        ]
                                                    );
                                                } elseif ($model->create_mode == 'paid' && $model->published == 0) {
                                                    $status .= Html::a(
                                                        Yii::t('app', 'Оплатить'),
                                                        ['/catalog/italian-product-grezzo/change-tariff', 'id' => $model->id],
                                                        [
//                                                            'data-method' => 'GET',
//                                                            'data-params' => [
//                                                                '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
//                                                                'id[]' => $model->id,
//                                                                'change_tariff' => 1,
//                                                            ],
                                                            'class' => 'btn-puplished btn-xs'
                                                        ]
                                                    );
                                                }

                                                return $status;
                                            },
                                            'headerOptions' => ['class' => 'col-sm-2'],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                        [
                                            'class' => yii\grid\ActionColumn::class,
                                            'template' => '{update}{delete}{sold}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    /** @var $model ItalianProduct */
                                                    return Html::a(
                                                        '<i class="fa fa-pencil" aria-hidden="true"></i> ' . Yii::t('app', 'Edit'),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product-grezzo/update', 'id' => $model->id]
                                                        ),
                                                        [
                                                            'class' => 'btn btn-default btn-xs'
                                                        ]
                                                    );
                                                },
                                                'delete' => function ($url, $model) {
                                                    /** @var $model ItalianProduct */
                                                    return Html::a(
                                                        '<i class="fa fa-trash" aria-hidden="true"></i> ' . Yii::t('app', 'Delete'),
                                                        Url::toRoute(
                                                            ['/catalog/italian-product-grezzo/intrash', 'id' => $model->id]
                                                        ),
                                                        [
                                                            'class' => 'btn btn-default btn-xs',
                                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                        ]
                                                    );
                                                },
                                                'sold' => function ($url, $model) {
                                                    /** @var $model ItalianProduct */
                                                    return $model->published == 1
                                                        ? Html::a(
                                                            '<span class="glyphicon glyphicon-shopping-cart"></span> ' . Yii::t('app', 'Item sold'),
                                                            Url::toRoute(
                                                                ['/catalog/italian-product-grezzo/is-sold', 'id' => $model->id]
                                                            ),
                                                            [
                                                                'class' => 'btn btn-default btn-xs',
                                                                'data-confirm' => Yii::t('yii', 'Are you sure?'),
                                                            ]
                                                        )
                                                        : '';
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
                                                if ($model->published || $model->create_mode == 'free') {
                                                    return ['disabled' => true];
                                                } else {
                                                    return [];
                                                }
                                            },
                                            'header' => Yii::t('app', 'Select'),
                                            'contentOptions' => ['class' => 'kv-row-select'],
                                        ]
                                    ],
                                ]) ?>

                                <?php if (isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id == 4) {
                                    echo $this->render('parts/_list_block_pay_for_all', [
                                        'dataProvider' => $dataProvider
                                    ]);
                                } ?>

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
