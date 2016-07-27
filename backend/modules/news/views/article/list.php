<?php
use thread\widgets\grid\ActionEditColumn;
use thread\widgets\grid\ActionToTrashColumn;
//
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\news\models\search\Article $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'title' => Yii::t('app', 'Article'),
    'columns' => [
//        ['class' => CheckboxColumn::class],
        'lang.title',
        'published_time:date',
//        [
//            'attribute' => 'group_id',
//            'value' => 'group.lang.title',
//        ],
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
