<?php

use yii\helpers\Html;
//
use backend\widgets\GridView\gridColumns\ActionColumn;
use backend\widgets\GridView\GridView;
use backend\modules\catalog\models\{
    Category, Types, search\Types as filterTypes
};
//
use thread\widgets\grid\{
    ActionStatusColumn, GridViewFilter
};
use yii\helpers\Url;

/** @var $model Types */
/** @var $filter filterTypes */

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
            'attribute' => 'category',
            'value' => function ($model) {
                /** @var $model Types */
                $result = [];
                foreach ($model->category as $category) {
                    $result[] = ($category->lang) ? $category->lang->title : '(не задано)';
                }
                return implode(', ', $result);
            },
            'label' => Yii::t('app', 'Category'),
            'filter' => GridViewFilter::selectOne($filter, 'category', Category::dropDownList()),
            'headerOptions' => ['class' => 'col-sm-4'],
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                /** @var $model Types */
                return Html::a(
                    Yii::t('app', 'Типы') . ' (' . $model->getChildrenCount() . ')',
                    ['/catalog/types/list', 'parent_id' => $model['id']]
                );
            },
            'visible' => ($this->context->parent) ? false : true
        ],
        [
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionColumn::class,
            'updateLink' => function ($model) {
                return Url::toRoute([
                    'update',
                    'parent_id' => $model['parent_id'],
                    'id' => $model['id']
                ]);
            },
            'deleteLink' => function ($model) {
                return Url::toRoute([
                    'intrash',
                    'parent_id' => $model['parent_id'],
                    'id' => $model['id']
                ]);
            }
        ],
    ]
]);
