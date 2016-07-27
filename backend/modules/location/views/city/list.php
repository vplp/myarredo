<?php
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\location\models\search\City $model
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'title' => Yii::t('app', 'City'),
    'columns' => [
        'lang.title',
        [
            'attribute' => 'location_country_id',
            'value' => 'country.lang.title',
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
