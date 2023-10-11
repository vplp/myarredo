<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};
use backend\modules\location\models\search\Country;

/**
 * @var $model Country
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        'alias',
        [
            'label' => Yii::t('app', 'Title'),
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'show_for_registration',
            'action' => 'show-for-registration'
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'show_for_filter',
            'action' => 'show-for-filter'
        ],
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
