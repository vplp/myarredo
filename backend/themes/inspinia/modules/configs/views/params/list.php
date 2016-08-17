<?php
use yii\helpers\Html;
use backend\themes\inspinia\widgets\GridView;

echo GridView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'group_id',
            'value' => 'group.lang.title',
            'label' => Yii::t('app', 'Group'),
            'filter' => Html::activeDropDownList($filter, 'group_id', \backend\modules\configs\models\Group::dropDownList(),
                ['class' => 'form-control', 'prompt' => '  ---  '])
        ],
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        'value',
        [
            'class' => \backend\themes\inspinia\widgets\gridColumns\ActionColumn::class
        ],
    ]
]);
