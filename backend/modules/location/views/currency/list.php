<?php
use thread\widgets\grid\SwitchboxColumn;
use thread\widgets\grid\ActionEditColumn;
use thread\widgets\grid\ActionToTrashColumn;
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\location\models\search\Currency $model
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'title' => Yii::t('app', 'Currency'),
    'columns' => [
        'alias',
        'lang.title',
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
