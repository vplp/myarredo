<?php

use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    ActionStatusColumn
};

/**
 * @var \backend\modules\banner\models\BannerItem $model
 * @var \backend\modules\banner\models\BannerItemLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

/**
 * @var \backend\modules\banner\models\search\BannerItem $model
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
