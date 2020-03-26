<?php

use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};
//
use backend\app\bootstrap\ActiveForm;
use backend\widgets\GridView\{
    GridView, gridColumns\ActionColumn
};
use backend\modules\catalog\models\{
    Factory, FactoryLang
};
use backend\modules\location\models\Country;

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

$visible = in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])
    ? true
    : false;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        [
            'attribute' => 'title',
            'value' => 'title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => Yii::t('app', 'Producing country'),
            'value' => 'producingCountry.title',
            'filter' => GridViewFilter::selectOne($filter, 'producing_country_id', Country::dropDownList()),
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular',
            'action' => 'popular',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_by',
            'action' => 'popular_by',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'popular_ua',
            'action' => 'popular_ua',
            'visible' => $visible
        ],
        [
            'class' => ActionColumn::class,
        ],
    ]
]);
