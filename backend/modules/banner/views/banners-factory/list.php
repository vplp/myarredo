<?php

use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\Factory;
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
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => Yii::t('app', 'Factory'),
            'value' => 'factory.title',
            'filter' => GridViewFilter::selectOne($filter, 'factory_id', Factory::dropDownList()),
        ],
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
