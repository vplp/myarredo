<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};

/**
 * @var \backend\modules\location\models\search\Country $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'label' => Yii::t('app', 'Title'),
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        'position',
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
