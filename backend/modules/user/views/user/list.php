<?php

use yii\helpers\Html;
//
use backend\themes\inspinia\widgets\GridView;
use backend\modules\user\models\Group;

/**
 *
 * @package admin\modules\menu\view
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 *
 * @var User $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'username',
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title',
            'filter' => Group::dropDownList()
        ],
        [
            'class' => \thread\widgets\grid\ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                /** @var $model User */
                return Html::a(Yii::t('app', 'Edit profile'), ['/user/profile/update', 'id' => $model->profile->id]);
            },
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('app', 'Change password'), ['password-change', 'id' => $model->id]);
            },
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
