<?php

use yii\helpers\Html;
//
use backend\widgets\GridView\GridView;
use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItemBackground, BannerItemLang
};
use backend\modules\location\models\{
    Country, City
};
//
use thread\widgets\grid\{ActionStatusColumn, GridViewFilter};

/**
 * @var $model BannerItemBackground
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
                /** @var $model BannerItemBackground */
                $result = [];
                foreach ($model->cities as $city) {
                    $result[] = $city->getTitle();
                }
                return ($result) ? implode(' | ', $result) : '-';
            },
            'filter' => GridViewFilter::selectOne($filter, 'city_id', City::dropDownListWithGroup()),
        ],
        'side',
        [
            'attribute' => 'background_code',
            'value' => function ($model) {
                /** @var $model BannerItemBackground */
                return Html::tag(
                    'span',
                    '&nbsp;&nbsp;&nbsp;',
                    ['style' => 'background-color: ' . $model->background_code]
                );
            },
            'format' => 'raw',
        ],
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
