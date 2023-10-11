<?php

use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};
//
use backend\widgets\GridView\GridView;
use backend\modules\sys\modules\mailcarrier\models\MailBox;

/**
 * @var $model \backend\modules\news\models\Group
 * @var $filter \backend\modules\news\models\search\Group
 */
echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'class' => \thread\widgets\grid\kartik\EditableColumn::class,
            'attribute' => 'title',
            'displayValue' => function ($model) {
                return $model->getTitle();
            }
        ],
        [
            'class' => \thread\widgets\grid\kartik\EditableDropDownColumn::class,
            'attribute' => 'mailbox_id',
            'link' => ['attribute-save-mailbox'],
            'data' => MailBox::dropDownList(),
            'displayValue' => function ($model) {
                return $model['mailbox']['lang']['title'];
            },
            'filter' => GridViewFilter::selectOne($filter, 'mailbox_id', ['0' => '---'] + MailBox::dropDownList()),
        ],
        [
            'value' => function () {
                return 'test';
            }
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class,
            'deleteLink' => function ($model) {
                return ($model['id'] !== 1);
            }
        ],
    ]
]);
