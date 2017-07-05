<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
//
use backend\modules\user\models\Group;
//
use thread\widgets\grid\{
    ActionCheckboxColumn, GridViewFilter
};

/**
 *
 * @var $model \backend\modules\user\models\User
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title',
            'filter' => GridViewFilter::selectOne($filter, 'group_id', Group::dropDownList()),
        ],
        'username',
        [
            'value' => function ($model) {
                return $model->profile->getFullName();
            }
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => function ($model) {
                return (in_array($model['id'], [1])) ? false : 'published';
            },
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('user', 'Edit profile'), ['/user/profile/update', 'id' => $model->profile->id]);
            },
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('user', 'Change password'), ['/user/password/change', 'id' => $model->id]);
            },
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'deleteLink' => function ($model) {
                return (in_array($model['id'], [1])) ? false : ['intrash', 'id' => $model['id']];
            }
        ],
    ]
]);
