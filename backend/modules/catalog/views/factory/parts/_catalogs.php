<?php

use yii\grid\GridView;
use yii\helpers\{
    Url, Html
};
use backend\modules\catalog\models\FactoryFile;

/**
 * @var \backend\modules\catalog\models\Factory $model
 */

echo GridView::widget([
    'dataProvider' => (new FactoryFile())->search([
        'FactoryFile' => [
            'factory_id' => $model->id,
            'file_type' => '1']
    ]),
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'title',
            'label' => Yii::t('app', 'Title'),
        ],
        'updated_at:datetime',
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'updateLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/factory-file/update',
                    'factory_id' => $model['factory_id'],
                    'file_type' => $model['file_type'],
                    'id' => $model['id']
                ]);
            },
            'deleteLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/factory-file/intrash',
                    'factory_id' => $model['factory_id'],
                    'file_type' => $model['file_type'],
                    'id' => $model['id']
                ]);
            }
        ],
    ]
]);

echo Html::a(
    Yii::t('app', 'Add'),
    ['/catalog/factory-file/create', 'factory_id' => $model['id'], 'file_type' => 1],
    ['class' => 'btn btn-info']
);