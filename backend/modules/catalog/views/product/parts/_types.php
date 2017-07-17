<?php

use backend\modules\catalog\models\Types;
//
use backend\modules\catalog\models\TypesRelCategory;
//
use backend\themes\defaults\widgets\TreeGrid;

?>

<?= TreeGrid::widget([
    'dataProvider' => (new Types())->search(Yii::$app->request->queryParams),
    'keyColumnName' => 'id',
    'parentColumnName' => 'parent_id',
    'options' => ['class' => 'table table-striped'],
    'columns' => [
        [
            'attribute' => 'title',
            'value' => 'lang.title',
            'label' => Yii::t('app', 'Title'),
        ],
        [
            'attribute' => 'Добавить',
            'class' => \thread\widgets\grid\AjaxManyToManyCheckboxColumn::class,
            'primaryKeyFirstTable' => 'type_id',
            //'attributeRow' => 'published',
            'primaryKeySecondTable' => 'group_id',
            'valueSecondTable' => Yii::$app->getRequest()->get('id'),
            'namespace' => TypesRelCategory::className(),
        ],
    ]
]); ?>

