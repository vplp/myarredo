<?php

use yii\grid\GridView;
use yii\helpers\{
    Url, Html
};
use backend\app\bootstrap\ActiveForm;
use backend\modules\sys\modules\logbook\models\Logbook;
use backend\modules\catalog\models\{
    Product, ProductLang
};

/**
 * @var $form ActiveForm
 * @var $model Product
 * @var $modelLang ProductLang
 */

echo GridView::widget([
    'dataProvider' => (new Logbook())->search(['Logbook' => ['model_id' => $model->id, 'model_name' => 'Product']]),
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
