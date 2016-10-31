<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn
};

/**
 *
 * @package backend\modules\shop\view
 * @author Alla Kuzmenko
 * @copyright (c) 2015, Thread
 *
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->queryParams),    
    'columns' => [
        'manager_id',
        'customer.full_name',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return $model->getCreatedTime();
            },
        ],
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
            'class' => ActionEditColumn::class,
        ],
        [
            'class' => ActionToTrashColumn::class
        ],
    ],
]);
