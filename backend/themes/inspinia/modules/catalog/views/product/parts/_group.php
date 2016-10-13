<?php

use backend\modules\catalog\models\Product;
use thread\modules\catalog\models\RelGroupProduct;
use backend\themes\inspinia\widgets\TreeGrid;

?>

<h1><?= Yii::t('app', 'Category') ?></h1>

<div id="w1" class="ibox float-e-margins">
    <div class="ibox-title">
        <h5> <?= Yii::t('app', 'Product cards') ?></h5>
        <div class="ibox-tools">
        </div>
    </div>
    <div class="ibox-content">
        <div class="row"></div>
        <div class="table-responsive">
            <?= TreeGrid::widget([
                'dataProvider' => Product::getSearchModelsCategory(),

                'keyColumnName' => 'id',
                'parentColumnName' => 'parent_id',
                'options' => ['class' => 'table table-striped'],
                'columns' => [
                    [
                        'attribute' => 'title',
                        'value' => 'lang.title',
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

        </div>
    </div>
</div>