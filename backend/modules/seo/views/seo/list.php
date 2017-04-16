<?php
use backend\themes\defaults\widgets\GridView;

/**
 * @var \backend\modules\page\models\search\Page $model
 */
echo GridView::widget(
    [
        'dataProvider' => $model->search(Yii::$app->request->queryParams),
        'title' => Yii::t('app', 'Pages'),
        'columns' => [
    //        [
    //            'attribute' => 'model_namespace',
    //            'value' => 'lang.title',
    //            'label' => Yii::t('app', 'Title'),
    //        ],
            'model_namespace',
            'in_search',
            'in_robots',
            'in_site_map',
            'lang.title',
            'lang.description',
            'lang.keywords',
            [
                'class' => \thread\widgets\grid\ActionCheckboxColumn::class,
                'attribute' => 'published',
                'action' => 'published'
            ],
            [
                'class' => \backend\themes\defaults\widgets\gridColumns\ActionColumn::class,
            ],
        ]
    ]
);
