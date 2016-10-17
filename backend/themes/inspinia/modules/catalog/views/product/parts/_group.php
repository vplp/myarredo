<?php

use backend\modules\catalog\models\Group;
//
use backend\modules\catalog\models\RelGroupProduct;
//
use backend\themes\inspinia\widgets\TreeGrid;

?>

<h1><?= Yii::t('app', 'Group') ?></h1>

<div id="w1" class="ibox float-e-margins">
    <div class="ibox-title">
        <h5> <?= Yii::t('app', 'Product') ?></h5>
        <div class="ibox-tools">
        </div>
    </div>
    <div class="ibox-content">
        <div class="row"></div>
        <div class="table-responsive">
            <?= TreeGrid::widget([
                'dataProvider' => (new Group())->search(Yii::$app->request->queryParams),
                'keyColumnName' => 'id',
                'parentColumnName' => 'parent_id',
                'options' => ['class' => 'table table-striped'],
                'columns' => [
                    [
                        'attribute' => 'title',
                        'value' => 'lang.title',
                    ],
                    'id',
                    'parent_id',
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