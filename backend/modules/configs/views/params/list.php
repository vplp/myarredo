<?php

use yii\grid\GridView;
use yii\helpers\Html;
//
use thread\widgets\grid\{
    ActionEditColumn, ActionToTrashColumn, ActionCheckboxColumn
};

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title',
            'label' => Yii::t('app', 'Group'),
            'filter' => Html::activeDropDownList($filter, 'group_id', \backend\modules\configs\models\Group::dropDownList(),
                ['class' => 'form-control', 'prompt' => '  ---  '])
        ],
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        'value',
        [
            'class' => ActionEditColumn::class,
        ],
        [
            'class' => ActionToTrashColumn::class
        ],
    ]
]);
