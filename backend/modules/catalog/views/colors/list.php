<?php

use yii\helpers\Html;
use backend\widgets\GridView\GridView;
use backend\widgets\GridView\gridColumns\ActionColumn;
use backend\modules\catalog\models\{
    Colors, ColorsLang
};
use thread\widgets\grid\{
    ActionStatusColumn
};

/**
 * @var $model Colors
 * @var $filter Colors
 * @var $modelLang ColorsLang
 */

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
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
            'class' => ActionStatusColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => ActionColumn::class
        ],
    ]
]);
