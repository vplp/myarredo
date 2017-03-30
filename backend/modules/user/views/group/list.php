<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};

/**
 * @var \backend\modules\user\models\search\Group $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        'role',
        [
            'label' => 'User',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('app', 'Users') . ' (' . $model->getUsersCount() . ')',
                    ['/user/user/list', 'User[group_id]' => $model['id']]);
            }
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
