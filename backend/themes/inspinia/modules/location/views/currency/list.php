<?php
use thread\widgets\grid\{
    ActionCheckboxColumn
};
//
use backend\themes\inspinia\widgets\GridView;
/**
 * @var \backend\modules\location\models\search\Currency $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'alias',
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        'course',
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
