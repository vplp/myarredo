<?php

use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\user\models\search\Group $model
 */

$filter = new \backend\modules\user\models\search\Group();
$filter->setAttributes(Yii::$app->getRequest()->get('Group'));

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
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
