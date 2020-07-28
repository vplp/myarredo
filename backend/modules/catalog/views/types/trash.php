<?php

use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Types, search\Types as filterTypes
};

/** @var $model Types */
/** @var $filter filterTypes */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
