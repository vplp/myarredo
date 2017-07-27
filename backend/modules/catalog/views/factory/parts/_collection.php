<?php

use yii\grid\GridView;
use yii\helpers\Url;
use backend\modules\catalog\models\Collection;

/**
 * @var \backend\modules\catalog\models\Factory $model
 */

echo GridView::widget([
    'dataProvider' => (new Collection())->search(['Collection' => ['factory_id' => $model->id]]),
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'updateLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/collection/update',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            },
            'deleteLink' => function ($model) {
                return Url::toRoute([
                    '/catalog/collection/intrash',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            }
        ],
    ]
]);