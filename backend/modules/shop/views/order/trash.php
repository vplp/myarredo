<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};

/**
 *
 * @package admin\modules\order\view
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
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
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
