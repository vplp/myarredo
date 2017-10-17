<?php

use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    ActionStatusColumn
};

/**
 * @var \backend\modules\catalog\models\Category $model
 * @var \backend\modules\catalog\models\CategoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
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
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular',
            'action' => 'popular'
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_by',
            'action' => 'popular_by'
        ],
        'position',
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
