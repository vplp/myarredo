<?php

use backend\widgets\TreeGrid;
use backend\modules\catalog\models\{
    ProductRelSpecification, Specification
};
use backend\modules\catalog\widgets\grid\ManyToManySpecificationValueDataColumn;
use yii\helpers\Html;

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo $form->text_line($model, 'volume');

?>

    <table class="table table-striped table-bordered">
        <?php foreach (Specification::findBase()->andWhere(['parent_id' => 0])->undeleted()->all() as $spec) { ?>
            <tr>
                <td colspan="2"><span style="font-weight: bold"><?= $spec['lang']['title'] ?></span></td>
            </tr>
            <?php foreach (Specification::findBase()->andWhere(['parent_id' => $spec['id']])->undeleted()->all() as $parentSpec) { ?>
                <tr>
                    <td><span><?= $parentSpec['lang']['title'] ?? '' ?></span></td>
                    <td class="form-inline">
                        <?php
                        $relationModel = ProductRelSpecification::findBase()
                            ->andWhere([
                                'catalog_item_id' => $model->id,
                                'specification_id' => $parentSpec['id']
                            ])
                            ->one();

                        if (in_array($parentSpec['id'], [6, 7, 8, 42]) && $parentSpec['type'] == 1) {
                            echo Html::input(
                                'text',
                                'SpecificationValue[' . $parentSpec->id . '][val]',
                                (isset($relationModel)) ? $relationModel->val : '',
                                ['class' => 'form-control i-checks', 'style' => 'width: 70px;']
                            );

                            for ($n = 2; $n <= 10; $n++) {
                                $field = "val$n";

                                echo Html::input(
                                    'text',
                                    'SpecificationValue[' . $parentSpec->id . '][' . $field . ']',
                                    (isset($relationModel)) ? $relationModel->$field : '',
                                    ['class' => 'form-control i-checks', 'style' => 'width: 70px;']
                                );
                            }
                        } elseif ($parentSpec['type'] == 1) {
                            echo Html::input(
                                'text',
                                'SpecificationValue[' . $parentSpec->id . ']',
                                (isset($relationModel)) ? $relationModel->val : '',
                                ['class' => 'form-control i-checks', 'style' => 'width: 70px;']
                            );
                        } else {
                            echo Html::checkbox(
                                'SpecificationValue[' . $parentSpec->id . ']',
                                (isset($relationModel)) ? $relationModel->val : '',
                                ['class' => 'form-control i-checks']
                            );
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>


<?php
//if (!$model->isNewRecord) {
//    echo TreeGrid::widget([
//        'dataProvider' => (new Specification())->search(Yii::$app->request->queryParams),
//        'keyColumnName' => 'id',
//        'parentColumnName' => 'parent_id',
//        'options' => ['class' => 'table table-striped table-bordered'],
//        'columns' => [
//            [
//                'attribute' => 'title',
//                'value' => 'lang.title',
//                'label' => Yii::t('app', 'Title'),
//            ],
//            [
//                'attribute' => 'val',
//                'class' => ManyToManySpecificationValueDataColumn::class,
//                'primaryKeyFirstTable' => 'specification_id',
//                'attributeRow' => 'val',
//                'primaryKeySecondTable' => 'catalog_item_id',
//                'valueSecondTable' => Yii::$app->getRequest()->get('id'),
//                'namespace' => ProductRelSpecification::class,
//            ],
//        ]
//    ]);
//}
