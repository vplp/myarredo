<?php

use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};
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

$visible = in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor']) ? true : false;

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
            'filter' => GridViewFilter::selectOne(
                $filter,
                'producing_country_id',
                Country::dropDownListForRegistration()
            ),
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'show_for_ru',
            'action' => 'show_for_ru',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'show_for_by',
            'action' => 'show_for_by',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'show_for_ua',
            'action' => 'show_for_ua',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'show_for_com',
            'action' => 'show_for_com',
            'visible' => $visible
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionColumn::class,
        ],
    ]
]);
