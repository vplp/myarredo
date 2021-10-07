<?php

use backend\widgets\GridView\GridView;
use thread\widgets\grid\{GridViewFilter};
use backend\modules\sys\modules\logbook\models\Logbook;

/**
 * @var $model Logbook
 * @var $filter \backend\modules\sys\modules\logbook\models\search\Logbook
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->getQueryParams()),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return $model->getModifiedTimeISO();
            },
            'filter' => GridViewFilter::datePickerRange($filter, 'date_from', 'date_to'),
        ],
        [
            'attribute' => 'user_id',
            'value' => 'user.username',
            'filter' => GridViewFilter::selectOne($filter, 'user_id', Logbook::dropDownListUsers()),
        ],
        'category',
        [
            'attribute' => 'message',
            'format' => 'raw',
            'value' => function ($model) {
                return \yii\helpers\Html::a($model['message'], $model['url']);
            }
        ],
    ]
]);
