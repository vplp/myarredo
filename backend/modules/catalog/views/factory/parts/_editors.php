<?php

use yii\grid\GridView;
use yii\helpers\{
    Url, Html
};
use backend\app\bootstrap\ActiveForm;
use backend\modules\sys\modules\logbook\models\Logbook;
use backend\modules\catalog\models\{
    Factory, FactoryLang
};

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
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
