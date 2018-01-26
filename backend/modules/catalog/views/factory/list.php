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
            'action' => 'popular'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_by',
            'action' => 'popular_by'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_ua',
            'action' => 'popular_ua'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
