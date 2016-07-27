<?php
use thread\widgets\grid\SwitchboxColumn;
use yii\helpers\Html;
use thread\widgets\grid\ActionEditColumn;
use thread\widgets\grid\ActionToTrashColumn;
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'columns' => [
        'lang.title',
        [
            'label' => 'Articles',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('app', 'Articles') . ' (' . count($model->articles) . ')', ['/news/article/list']);
            }
        ],
        [
            'class' => \thread\widgets\grid\ActionCheckboxColumn::class,
            'attribute' => 'published',
            'action' => 'published'
        ],
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
