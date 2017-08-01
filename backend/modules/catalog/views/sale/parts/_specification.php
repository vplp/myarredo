<?php

use backend\modules\catalog\models\{
    SpecificationRelSale, Specification
};
use backend\modules\catalog\widgets\grid\ManyToManySpecificationDataColumn;
//
use backend\themes\defaults\widgets\TreeGrid;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model backend\modules\catalog\models\Product */
?>

<?= $form->text_line($model, 'volume') ?>

<?php if (!$model->isNewRecord): ?>

    <?= TreeGrid::widget([
        'dataProvider' => (new Specification())->search(Yii::$app->request->queryParams),
        'keyColumnName' => 'id',
        'parentColumnName' => 'parent_id',
        'options' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            [
                'attribute' => 'title',
                'value' => 'lang.title',
                'label' => Yii::t('app', 'Title'),
            ],
            [
                'attribute' => 'val',
                'class' => ManyToManySpecificationDataColumn::class,
                'primaryKeyFirstTable' => 'specification_id',
                'attributeRow' => 'val',
                'primaryKeySecondTable' => 'sale_catalog_item_id',
                'valueSecondTable' => Yii::$app->getRequest()->get('id'),
                'namespace' => SpecificationRelSale::className(),
            ],
        ]
    ]); ?>

<?php endif; ?>
