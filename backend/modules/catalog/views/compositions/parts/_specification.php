<?php

use backend\modules\catalog\models\{
    ProductRelSpecification, Specification
};
use backend\modules\catalog\widgets\grid\ManyToManySpecificationValueDataColumn;
use backend\widgets\TreeGrid;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Composition, CompositionLang
};

/**
 * @var $form ActiveForm
 * @var $model Composition
 * @var $modelLang CompositionLang
 */

if (!$model->isNewRecord) {
    echo TreeGrid::widget([
        'dataProvider' => (new Specification())->search(Yii::$app->request->queryParams),
        'keyColumnName' => 'id',
        'parentRootValue' => 9,
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
                'class' => ManyToManySpecificationValueDataColumn::class,
                'primaryKeyFirstTable' => 'specification_id',
                'attributeRow' => 'val',
                'primaryKeySecondTable' => 'catalog_item_id',
                'valueSecondTable' => Yii::$app->getRequest()->get('id'),
                'namespace' => ProductRelSpecification::className(),
            ],
        ]
    ]);
}
