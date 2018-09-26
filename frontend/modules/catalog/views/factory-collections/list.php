<?php

use yii\helpers\{
    Html, Url
};
use kartik\grid\GridView;
use frontend\components\Breadcrumbs;

/**
 * @var \yii\data\Pagination $pages
 * @var $model \frontend\modules\catalog\models\Collection
 */

$dataProvider = $model->search(Yii::$app->request->queryParams);
$dataProvider->sort = false;

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row title-cont">

                <?= Html::tag('h1', $this->context->title); ?>

                <?= Html::a(
                    '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add'),
                    Url::toRoute(['/catalog/factory-collections/create']),
                    ['class' => 'btn btn-goods']
                ) ?>

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>

            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div id="cont_goods" class="cont-area cont-goods">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $filter,
                                'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                                'filterUrl' => Url::toRoute(['/catalog/factory-collections/list']),
                                'columns' => [
                                    [
                                        'attribute' => 'title',
                                        'value' => 'title',
                                        'label' => Yii::t('app', 'Title'),
                                    ],
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'published',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Collection */
                                            return Html::checkbox(false, $model['published'], ['disabled' => true]);
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1'],
                                        'contentOptions' => ['class' => 'text-center']
                                    ],
                                    [
                                        'class' => yii\grid\ActionColumn::class,
                                        'template' => '{update}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\Collection */
                                                return Yii::$app->user->identity->profile->factory_id == $model['factory_id']
                                                    ? Html::a(
                                                        '<span class="glyphicon glyphicon-pencil"></span>',
                                                        Url::toRoute([
                                                            '/catalog/factory-collections/update',
                                                            'id' => $model['id']
                                                        ]),
                                                        [
                                                            'class' => 'btn btn-default btn-xs'
                                                        ]
                                                    )
                                                    : '';
                                            },
                                        ],
                                        'buttonOptions' => ['class' => 'btn btn-default btn-xs'],
                                        'headerOptions' => ['class' => 'col-sm-1',],
                                    ],
                                ],
                            ]); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
