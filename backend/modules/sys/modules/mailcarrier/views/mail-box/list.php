<?php

use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionStatusColumn
};

/**
 * @var $model \backend\modules\sys\modules\mailcarrier\models\MailBox
 * @var $modelLang \backend\modules\sys\modules\mailcarrier\models\MailBoxLang
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
        'host',
        'username',
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
