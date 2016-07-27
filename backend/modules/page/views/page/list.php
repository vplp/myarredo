<?php
use thread\widgets\grid\ActionEditColumn;
use thread\widgets\grid\ActionToTrashColumn;
//
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\page\models\search\Page $model
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'title' => Yii::t('app', 'Pages'),
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
