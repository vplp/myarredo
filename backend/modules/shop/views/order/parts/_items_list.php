<?php

use backend\modules\shop\models\OrderItem;
use yii\grid\GridView;

/**
 *
 * @package backend\modules\shop\view
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
 */
echo GridView::widget([
    'dataProvider' => (new OrderItem())->items($model->id),
    'columns' => [
        'product_id',
        'count',
        'summ',
        'total_summ',
        'discount_percent',
        'discount_money',
        'discount_full',
        'extra_param',
    ],
]);
