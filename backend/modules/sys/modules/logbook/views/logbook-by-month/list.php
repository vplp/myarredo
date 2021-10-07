<?php

use backend\widgets\GridView\GridView;
use thread\widgets\grid\{GridViewFilter};
use backend\modules\sys\modules\logbook\models\LogbookByMonth;

/**
 * @var $model LogbookByMonth
 * @var $filter \backend\modules\sys\modules\logbook\models\search\LogbookByMonth
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->getRequest()->getQueryParams()),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'user_id',
            'value' => 'user.username',
            'filter' => GridViewFilter::selectOne($filter, 'user_id', LogbookByMonth::dropDownListUsers()),
        ],
        [
            'attribute' => 'action_method',
            'format' => 'raw',
            'value' => function ($model) {
                $action_method = [
//                    'updateProduct' => 'редактирование товара',
//                    'updateImageProduct' => 'добавление новых фото',
//                    'updateGalleryProduct' => 'добавление новых фото',
                ];
                return array_key_exists($model->action_method, $action_method) ? $action_method[$model->action_method] : $model->action_method;
            },
            'filter' => GridViewFilter::selectOne($filter, 'action_method', LogbookByMonth::dropDownListActionMethod()),
        ],
        [
            'attribute' => 'action_date',
            'value' => function ($model) {
                return date('m.Y', $model->action_date);
            },
            'filter' => GridViewFilter::datePickerRange($filter, 'date_from', 'date_to'),
        ],
        'count',
    ]
]);
