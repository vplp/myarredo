<?php

use backend\widgets\GridView;
use thread\widgets\grid\GridViewFilter;
use backend\modules\forms\models\ClickOnBecomePartner;
use backend\modules\location\models\{
    Country, City
};

/**
 * @var ClickOnBecomePartner $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        [
            'attribute' => Yii::t('app', 'Country'),
            'value' => 'country.title',
            'filter' => GridViewFilter::selectOne($filter, 'country_id', ClickOnBecomePartner::dropDownListCountries()),
        ],
        [
            'attribute' => Yii::t('app', 'City'),
            'value' => 'city.title',
            'filter' => GridViewFilter::selectOne($filter, 'city_id', ClickOnBecomePartner::dropDownListCities()),
        ],
        [
            'format' => 'raw',
            'label' => 'Число нажатий',
            'value' => function ($model) {
                /** @var ClickOnBecomePartner $model */
                return $model->count;
            },
        ],
    ]
]);
