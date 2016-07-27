<?php
use backend\themes\inspinia\widgets\GridView;

/**
 * @var $model \backend\modules\forms\models\search\Topic
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'title' => Yii::t('app', 'Topic form'),
    'columns' => [
        'lang.title',
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
