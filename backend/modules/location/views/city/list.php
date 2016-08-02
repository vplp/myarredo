<?php
use backend\themes\inspinia\widgets\GridView;
use backend\modules\location\models\Country;

/**
 * @var \backend\modules\location\models\search\City $model
 */

$filter = new \backend\modules\location\models\search\City();
$filter->setAttributes(Yii::$app->getRequest()->get('City'));

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
            'attribute' => 'location_country_id',
            'value' => 'country.lang.title',
            'filter' => Country::dropDownList()
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
