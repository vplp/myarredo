<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};

/**
 * @var $model \backend\modules\sys\modules\configs\models\Group
 * @var $modelLang \backend\modules\sys\modules\configs\models\GroupLang
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
        ],
        [
            'label' => 'Articles',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('app', 'Params') . ' (' . $model->getParamsCount() . ')',
                    ['/configs/params/list', 'Params[group_id]' => $model['id']]);
            }
        ],
        [
            'class' => ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\widgets\GridView\gridColumns\ActionColumn::class
        ],
    ]
]);
