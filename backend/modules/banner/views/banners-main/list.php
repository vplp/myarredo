<?php

use backend\widgets\GridView\GridView;
use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItemMain, BannerItemLang
};
use backend\modules\location\models\{
    Country, City
};
use thread\widgets\grid\{ActionStatusColumn, GridViewFilter};

/**
 * @var $model BannerItemMain
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
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
        'position',
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
