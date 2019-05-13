<?php

use backend\widgets\GridView;
use backend\modules\rules\models\{
    Rules, search\Rules as SearchRules
};
use backend\widgets\gridColumns\ActionColumn;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};

/**
 * @var Rules $model
 * @var SearchRules $filter
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        'position',
        [
            'class' => ActionColumn::class
        ],
    ]
]);
