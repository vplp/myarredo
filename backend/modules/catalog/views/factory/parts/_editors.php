<?php

use yii\grid\GridView;
use backend\modules\sys\modules\logbook\models\Logbook;
use backend\modules\catalog\models\Factory;

/**
 * @var $model Factory
 */

echo GridView::widget([
    'dataProvider' => (new Logbook())->search(['Logbook' => ['model_id' => $model->id, 'model_name' => 'Factory']]),
    'columns' => [
        [
            //'attribute' => 'created_at',
            'value' => function ($model) {
                /** @var $model Logbook */
                return $model->getModifiedTimeISO();
            }
        ],
        [
            'attribute' => 'user_id',
            'value' => 'user.profile.fullName',
        ]
    ]
]);
