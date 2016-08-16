<?php

use yii\helpers\Html;
//
use kartik\widgets\DatePicker;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};
//
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\news\models\search\Article $model
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'group_id',
            'filter' => Html::activeDropDownList($filter, 'group_id', \backend\modules\news\models\Group::dropDownList(),
                ['class' => 'form-control', 'prompt' => '  ---  '])
        ],
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'published_time',
            'filter' => DatePicker::widget([
                'model' => $filter,
                'attribute' => 'date_from',
                'attribute2' => 'date_to',
                'options' => ['placeholder' => 'Start date'],
                'options2' => ['placeholder' => 'End date'],
                'type' => DatePicker::TYPE_RANGE,
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose' => true,
                ]
            ]),
            'value' => function ($model) {
                return $model->getPublishedTime();
            },
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
