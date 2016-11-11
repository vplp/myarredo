<?php

use backend\modules\catalog\models\Group;
//
use backend\modules\catalog\models\RelGroupProduct;
//
use backend\themes\inspinia\widgets\TreeGrid;

/**
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\modules\catalog\models\Product $model
 */

?>

<?= TreeGrid::widget([
    'dataProvider' => (new Group())->search(Yii::$app->request->queryParams),
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
            'attributeRow' => 'published',
            'primaryKeySecondTable' => 'product_id',
            'valueSecondTable' => Yii::$app->getRequest()->get('id'),
            'namespace' => RelGroupProduct::className(),
        ],
    ]
]); ?>

