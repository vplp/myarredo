<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
use backend\modules\catalog\models\{
    Colors, ColorsLang
};

/**
 * @var $model Colors
 * @var $filter Colors
 * @var $modelLang ColorsLang
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        'alias',
        [
            'attribute' => 'color_code',
            'value' => function ($model) {
                /** @var $model Colors */
                return Html::tag(
                    'span',
                    '&nbsp;&nbsp;&nbsp;',
                    ['style' => 'background-color: ' . $model->color_code]
                );
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'title',
            'value' => function ($model) {
                return $model->getTitle();
            },
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'plural_title',
            'value' => 'lang.plural_title',
            'label' => Yii::t('app', 'Plural title'),
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
