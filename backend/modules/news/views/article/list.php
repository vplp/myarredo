<?php
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\news\models\search\Article $model
 */

$filter = new \backend\modules\news\models\search\Article();
$filter->setAttributes(Yii::$app->getRequest()->get('Article'));

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        'published_time:date',
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
