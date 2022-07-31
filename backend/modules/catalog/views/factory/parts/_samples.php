<?php

use yii\grid\GridView;
use yii\helpers\{
    Url, Html
};
use thread\widgets\grid\ActionStatusColumn;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{Factory, FactoryLang, FactorySamplesFiles};

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

echo GridView::widget([
    'dataProvider' => (new FactorySamplesFiles())->search([
        'FactorySamplesFiles' => [
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
            'attribute' => 'image_link',
            'value' => function ($model) {
                /** @var $model FactorySamplesFiles */
                return Html::img($model->getImageLink(), ['width' => 50]);
            },
            'label' => Yii::t('app', 'Image'),
            'format' => 'raw',
            'filter' => false
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return date('j.m.Y H:i', $model->updated_at);
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => '/catalog/factory-samples-files/published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'updateLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/factory-samples-files/update',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            },
            'deleteLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/factory-samples-files/intrash',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            }
        ],
    ]
]);

echo Html::a(
    Yii::t('app', 'Add'),
    ['/catalog/factory-samples-files/create', 'factory_id' => $model['id']],
    ['class' => 'btn btn-info']
);
