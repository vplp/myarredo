<?php

use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, SwitchboxColumn
};
use backend\themes\inspinia\widgets\GridView;

/**
 *
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'columns' => [
        'lang.title',
        'messagefilepath',
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
