<?php

use yii\grid\GridView;
use yii\helpers\{
    Url, Html
};
use backend\modules\catalog\models\FactoryPricesFiles;
use thread\widgets\grid\ActionStatusColumn;

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo GridView::widget([
    'dataProvider' => (new FactoryPricesFiles())->search([
        'FactoryPricesFiles' => [
            'factory_id' => $model->id,
        ]
    ]),
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'discount',
            'value' => 'discount',
            'label' => Yii::t('app', 'Discount'),
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return date('d.n.Y H:i', $model->updated_at);
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => '/catalog/factory-prices-files/published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'updateLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/factory-prices-files/update',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            },
            'deleteLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/factory-prices-files/intrash',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            }
        ],
    ]
]);

echo Html::a(
    Yii::t('app', 'Add'),
    ['/catalog/factory-prices-files/create', 'factory_id' => $model['id']],
    ['class' => 'btn btn-info']
);