<?php

use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\user\models\search\Group $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'title' => Yii::t('app', 'User groups'),
    'columns' => [
        'lang.title',
        'role',
        [
            'class' => \thread\widgets\grid\ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
