<?php

use backend\widgets\GridView;
use thread\widgets\grid\ActionStatusColumn;
use backend\modules\seo\models\Redirects;

/**
 * @var $model Redirects
 * @var $filter Redirects
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        'url_from',
        'url_to',
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\gridColumns\ActionColumn::class,
        ],
    ]
]);
