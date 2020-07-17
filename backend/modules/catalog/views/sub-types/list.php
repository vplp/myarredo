<?php

use yii\helpers\Url;
use backend\widgets\GridView\gridColumns\ActionColumn;
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    SubTypes, search\SubTypes as filterSubTypes
};
use thread\widgets\grid\{
    ActionStatusColumn
};

/** @var $model SubTypes */
/** @var $filter filterSubTypes */

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
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionColumn::class,
            'updateLink' => function ($model) {
                return Url::toRoute([
                    'update',
                    'parent_id' => $model['parent_id'],
                    'id' => $model['id']
                ]);
            },
            'deleteLink' => function ($model) {
                return Url::toRoute([
                    'intrash',
                    'parent_id' => $model['parent_id'],
                    'id' => $model['id']
                ]);
            }
        ],
    ]
]);
