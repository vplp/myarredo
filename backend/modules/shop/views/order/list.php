<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, ActionCheckboxColumn, GridViewFilter
};
use yii\helpers\Html;
use yii\helpers\Url;

/**
 *
 * @package backend\modules\shop\view
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->queryParams),
    'columns' => [
        'manager_id',
        'customer.full_name',
        'deliveryMethod.lang.title',
        'paymentMethod.lang.title',
        'delivery_price',
        'order_status',
        'payd_status',
        'items_count',
        'items_total_count',
        'items_summ',
        'items_total_summ',
        'discount_percent',
        'discount_money',
        'discount_full',
        'total_summ',
        'comment',
        [
            'format' => 'raw',
            'value' => function($model) {
                return Html::a('Позиции', Url::toRoute(['/shop/order-item/list', 'order_id' => $model->id]));
            }
        ],
        [
            'class' => ActionEditColumn::class,
        ],
        [
            'class' => ActionToTrashColumn::class
        ],
    ],
]);
