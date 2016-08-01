<?php
use thread\widgets\grid\SwitchboxColumn;
use yii\helpers\Html;
use backend\themes\inspinia\widgets\GridView;


$filter = new \backend\modules\news\models\search\Group();
$filter->setAttributes(Yii::$app->getRequest()->get('Group'));

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
            'label' => 'Articles',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Yii::t('app', 'Articles') . ' (' . count($model->articles) . ')',
                    ['/news/article/list']);
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
