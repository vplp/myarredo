<?php

use yii\grid\GridView;
use yii\helpers\{
    Url, Html
};
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\Collection;

/**
 * @var $model Collection
 * @var $form ActiveForm
 */

echo GridView::widget([
    'dataProvider' => (new Collection())->search(['Collection' => ['factory_id' => $model->id]]),
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'year',
            'value' => function ($model) {
                /** @var $model Collection */
                return $model->year > 0 ? $model->year : '';
            },
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                /** @var $model Collection */
                return date('j.m.Y H:i', $model->updated_at);
            },
            'format' => 'raw',
            'filter' => false
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'updateLink' => function ($model) {
                /** @var $model Collection */
                return Url::toRoute([
                    '/catalog/collection/update',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            },
            'deleteLink' => function ($model) {
                /** @var $model Collection */
                return Url::toRoute([
                    '/catalog/collection/intrash',
                    'factory_id' => $model['factory_id'],
                    'id' => $model['id']
                ]);
            }
        ],
    ]
]);

echo Html::a(
    Yii::t('app', 'Add'),
    ['/catalog/collection/create', 'factory_id' => $model['id']],
    ['class' => 'btn btn-info']
);
