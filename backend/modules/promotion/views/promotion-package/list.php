<?php

use backend\widgets\GridView;
use backend\modules\promotion\models\{
    PromotionPackage, search\PromotionPackage as SearchPromotionPackage
};
use backend\widgets\gridColumns\ActionColumn;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};
use yii\helpers\Html;

/**
 * @var PromotionPackage $model
 * @var SearchPromotionPackage $filter
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'image_link',
            'value' => function ($model) {
                /** @var PromotionPackage $model */
                return Html::img($model->getImageLink(), ['width' => 50]);
            },
            'label' => Yii::t('app', 'Image'),
            'format' => 'raw',
            'filter' => false
        ],
        'price',
        'currency',
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        'position',
        [
            'class' => ActionColumn::class
        ],
    ]
]);
