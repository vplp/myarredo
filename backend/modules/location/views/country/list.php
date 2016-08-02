<?php
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\location\models\search\Country $model
 */

$filter = new \backend\modules\location\models\search\Country();
$filter->setAttributes(Yii::$app->getRequest()->get('Country'));

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'alpha2',
        'alpha3',
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
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
