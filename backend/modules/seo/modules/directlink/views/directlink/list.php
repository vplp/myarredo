<?php

use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};
//
use backend\widgets\GridView;
use backend\modules\location\models\City;
use backend\modules\seo\modules\directlink\models\Directlink;

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
                /** @var $model Directlink */
                $result = [];
                foreach ($model->cities as $city) {
                    $result[] = $city->getTitle();
                }
                return ($result) ? implode(' | ', $result) : '-';
            },
            'filter' => GridViewFilter::selectOne($filter, 'city_id', City::dropDownListWithGroup()),
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
