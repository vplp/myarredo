<?php

use yii\grid\GridView;

/**
 *
 * @package backend\modules\shop\view
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
 */
echo GridView::widget([
    'dataProvider' => $model->items[0]->search(Yii::$app->getRequest()->queryParams),
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
