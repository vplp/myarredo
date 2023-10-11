<?php

use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    SubTypes, search\SubTypes as filterSubTypes
};

/** @var $model SubTypes */
/** @var $filter filterSubTypes */

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
