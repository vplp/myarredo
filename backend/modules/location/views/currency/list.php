<?php
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\location\models\search\Currency $model
 */

$filter = new \backend\modules\location\models\search\Currency();
$filter->setAttributes(Yii::$app->getRequest()->get('Currency'));

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
            'class' => \thread\widgets\grid\ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
