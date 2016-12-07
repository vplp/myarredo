<?php
use yii\helpers\Html;
//
use thread\widgets\grid\{
    ActionCheckboxColumn
};
//
use backend\themes\inspinia\widgets\GridView;

/**
 * @var \backend\modules\location\models\search\Country $model
 */

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
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(
                    Yii::t('location', 'City') . ': ' . ' (' . $model->getCitiesCount() . ')',
                    ['/location/city/list', 'country_id' => $model['id']]
                );
            }
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
