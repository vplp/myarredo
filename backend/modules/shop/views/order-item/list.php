<?php

use yii\grid\GridView;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, ActionCheckboxColumn, GridViewFilter
};
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

        'count',
        'total_count',
        'summ',
        'total_summ',
        'discount_percent',
        'discount_money',
        'discount_full',
        [
            'class' => ActionEditColumn::class,
        ],
        [
            'class' => ActionToTrashColumn::class
        ],
    ],
]);
