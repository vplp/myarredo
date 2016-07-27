<?php
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\location\models\search\Country $model
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'title' => Yii::t('app', 'Country'),
    'columns' => [
        'alpha2',
        'alpha3',
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
