<?php

use yii\grid\GridView;
use thread\widgets\grid\{
    ActionDeleteColumn, ActionRestoreColumn
};
use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItemMain, BannerItemLang
};

/**
 * @var $model BannerItemMain
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

echo GridView::widget([
    'dataProvider' => $model->trash(Yii::$app->request->queryParams),
    'filterModel' => $filter,
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'class' => ActionDeleteColumn::class,
        ],
        [
            'class' => ActionRestoreColumn::class
        ],
    ]
]);
