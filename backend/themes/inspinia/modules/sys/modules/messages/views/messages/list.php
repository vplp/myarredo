<?php

use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\news\models\search\Article $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'filterModel' => $filter,
    'columns' => [
//        'arraykey',
        [
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
