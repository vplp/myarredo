<?php

use yii\grid\GridView;
use yii\helpers\{
    Url, Html
};
use backend\modules\catalog\models\FactoryCatalogsFiles;
use thread\widgets\grid\ActionStatusColumn;

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo GridView::widget([
    'dataProvider' => (new FactoryCatalogsFiles())->search([
        'FactoryCatalogsFiles' => [
            'factory_id' => $model->id,
        ]
    ]),
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'title',
            'label' => Yii::t('app', 'Title'),
        ],
        'updated_at:datetime',
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => '/catalog/factory-catalogs-files/published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'updateLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/factory-catalogs-files/update',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            },
            'deleteLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/factory-catalogs-files/intrash',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            }
        ],
    ]
]);

echo Html::a(
    Yii::t('app', 'Add'),
    ['/catalog/factory-catalogs-files/create', 'factory_id' => $model['id']],
    ['class' => 'btn btn-info']
);