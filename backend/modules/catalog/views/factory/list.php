<?php

use thread\widgets\grid\{
    ActionStatusColumn
};
//
use backend\widgets\GridView\GridView;

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

$visible = in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])
    ? true
    : false;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular',
            'action' => 'popular',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_by',
            'action' => 'popular_by',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_ua',
            'action' => 'popular_ua',
            'visible' => $visible
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'deleteLink' => $visible
        ],
    ]
]);
