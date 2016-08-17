<?php
use yii\helpers\Html;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};
//
use backend\themes\inspinia\widgets\GridView;

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
            'label' => Yii::t('app', 'Title'),
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
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
