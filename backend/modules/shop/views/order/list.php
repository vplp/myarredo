<?php

use backend\widgets\GridView\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->queryParams),    
    'columns' => [
        'id',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return $model->getCreatedTime();
            },
        ],
//        [
//            'attribute' => 'customer',
//            'value' => function ($model) {
//                return $model->customer->full_name;
//            }
//        ],
//        [
//            'attribute' => 'deliveryMethod',
//            'value' => function ($model) {
//                return $model->deliveryMethod->lang->title;
//            }
//        ],
//        [
//            'attribute' => 'paymentMethod',
//            'value' => function ($model) {
//                return $model->paymentMethod->lang->title;
//            }
//        ],
//        [
//            'attribute' => 'order_status',
//            'value' => function ($model) {
//                return ($model->order_status == '') ? 'Новый' : $model->order_status;
//            }
//        ],
//        [
//            'attribute' => 'payd_status',
//            'value' => function ($model) {
//                return Yii::t('app', $model->payd_status);
//            }
//        ],
//        'total_summ',
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
        ],
    ],
]);