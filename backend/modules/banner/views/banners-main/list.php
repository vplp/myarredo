<?php

use backend\widgets\GridView\GridView;
use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItem, BannerItemLang
};
//
use thread\widgets\grid\{ActionStatusColumn, GridViewFilter};

/**
 * @var $model BannerItem
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'lang.title',
        'lang.description',
        'position',
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
