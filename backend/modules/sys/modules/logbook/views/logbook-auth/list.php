<?php

use backend\widgets\GridView\GridView;

/**
 * @var $model \backend\modules\sys\modules\logbook\models\Logbook
 * @var $filter \backend\modules\sys\modules\logbook\models\search\Logbook
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'action',
        [
            'attribute' => 'user_id',
            'value' => 'user.username',
        ],
        'user_agent',
        [
            'attribute' => 'user_ip',
            'headerOptions' => [
                'style' => 'vertical-align:middle; width:130px; text-align:center;',
            ],
            'contentOptions' => [
                'style' => 'vertical-align:middle; width:130px; text-align:center;',
            ],
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return \date('d.m.Y H:i P', $model['created_at']);
            },
            'headerOptions' => [
                'style' => 'vertical-align:middle; width:130px; text-align:center;',
            ],
            'contentOptions' => [
                'style' => 'vertical-align:middle; width:130px; text-align:center;',
            ],
        ],
    ]
]);
