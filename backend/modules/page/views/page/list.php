<?php
//
use backend\themes\inspinia\widgets\GridView;

$filter = new \backend\modules\page\models\search\Page();
$filter->setAttributes(Yii::$app->getRequest()->get('Page'));

/**
 * @var \backend\modules\page\models\search\Page $model
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
            'class' => \thread\widgets\grid\ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
