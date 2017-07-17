<?php

use backend\modules\catalog\models\Category;
//
use backend\modules\catalog\models\TypesRelCategory;
//
use backend\themes\defaults\widgets\TreeGrid;

?>

<?= TreeGrid::widget([
    'dataProvider' => (new Category())->search(Yii::$app->request->queryParams),
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
            'primaryKeyFirstTable' => 'group_id',
            'primaryKeySecondTable' => 'type_id',
            'valueSecondTable' => Yii::$app->getRequest()->get('id'),
            'namespace' => TypesRelCategory::className(),
        ],
    ]
]); ?>

