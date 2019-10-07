<?php

use backend\modules\catalog\models\SaleRequest;
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
                /** @var SaleRequest $model */
                return date('d.m.Y', $model->updated_at);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'sale_item_id',
            'value' => function ($model) {
                /** @var SaleRequest $model */
                return Html::a(
                    $model->sale->lang->title,
                    'https://www.myarredo.ru/sale-product/' . $model->sale->alias,
                    ['target' => '_blank']
                );
            },
        ],
        'offer_price',
        'user_name',
        'phone',
        'email',
    ]
]);
