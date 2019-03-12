<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionStatusColumn
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        'url',
        [
            'format' => 'raw',
            'label' => Yii::t('app', 'Cities'),
            'value' => function ($model) {
                /** @var \backend\modules\seo\modules\directlink\models\Directlink $model */
                $result = [];
                foreach ($model->cities as $city) {
                    $result[] = $city->lang->title;
                }

                return implode(' | ', $result);
            },
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
        ],
    ]
]);
