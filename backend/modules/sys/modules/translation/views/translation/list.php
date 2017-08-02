<?php

use \backend\widgets\GridView\gridColumns\ActionColumn;
use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};
//
use backend\widgets\GridView\GridView;
use backend\modules\sys\modules\translation\models\Source;
use backend\modules\sys\modules\translation\models\search\Source as SourceSearch;

/** @var Source $model */
/** @var SourceSearch $filter */

echo GridView::widget(
    [
        'dataProvider' => $model->search(Yii::$app->request->queryParams),
        'filterModel' => $filter,
        'columns' => [
            [
                'attribute' => 'category',
                'value' => 'category',
                'filter' => GridViewFilter::selectOne($filter, 'category', Source::listFromTo('category', 'category')),
            ],
            [
                'attribute' => 'key',
                'value' => 'key',
                'filter' => GridViewFilter::selectOne($filter, 'key', Source::listFromTo('key', 'key')),
            ],
            'message.translation',
            [
                'class' => ActionCheckboxColumn::class,
                'attribute' => 'published',
                'action' => 'published'
            ],
            [
                'class' => ActionColumn::class,
            ],
        ]
    ]
);
