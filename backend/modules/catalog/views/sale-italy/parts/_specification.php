<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang, ItalianProductRelSpecification, Specification
};
use backend\modules\catalog\widgets\grid\ManyToManySpecificationValueDataColumn;
use backend\widgets\TreeGrid;

/**
 * @var $form ActiveForm
 * @var $model ItalianProduct $model
 * @var $modelLang ItalianProductLang
 */

echo $form->text_line($model, 'volume');
echo $form->text_line($model, 'weight');
echo $form->text_line($model, 'production_year');

if (!$model->isNewRecord) {
    echo TreeGrid::widget([
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
                'class' => ManyToManySpecificationValueDataColumn::class,
                'primaryKeyFirstTable' => 'specification_id',
                'attributeRow' => 'val',
                'primaryKeySecondTable' => 'item_id',
                'valueSecondTable' => Yii::$app->getRequest()->get('id'),
                'namespace' => ItalianProductRelSpecification::className(),
            ],
        ]
    ]);
}
