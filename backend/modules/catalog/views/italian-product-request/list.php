<?php

use backend\modules\catalog\models\ItalianProductRequest;
use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    GridViewFilter
};
use yii\helpers\Html;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'id',
        [
            'format' => 'raw',
            'attribute' => 'updated_at',
            'label' => Yii::t('app', 'Дата'),
            'value' => function ($model) {
                /** @var ItalianProductRequest $model */
                return date('d.m.Y', $model->updated_at);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'item_id',
            'value' => function ($model) {
                /** @var ItalianProductRequest $model */
                if ($model->city == null || in_array($model->city['id'], [1, 2, 4, 159])) {
                    $url = 'https://' . 'www.myarredo.' . $model->city->country['alias'];
                } else {
                    $url = 'https://' . $model->city['alias'] . '.myarredo.' . $model->city->country['alias'];
                }

                return Html::a(
                    $model->italianProduct->lang->title,
                    $url . '/sale-italy-product/' . $model->italianProduct->alias,
                    ['target' => '_blank']
                );
            },
        ],
        'offer_price',
        [
            'format' => 'raw',
            'attribute' => 'city_id',
            'value' => function ($model) {
                /** @var ItalianProductRequest $model */
                return $model->city->lang->title;
            },
        ],
        'user_name',
        'phone',
        'email',
    ]
]);
