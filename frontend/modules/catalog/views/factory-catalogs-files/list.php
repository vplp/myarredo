<?php

use yii\helpers\{ArrayHelper, Html, Url};
use kartik\grid\GridView;
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\FactoryCatalogsFiles;

/**
 * @var \yii\data\Pagination $pages
 * @var $model FactoryCatalogsFiles
 */


$queryParams['FactoryCatalogsFiles']['factory_id'] = Yii::$app->user->identity->profile->factory_id;

$dataProvider = $model->search(ArrayHelper::merge(Yii::$app->request->queryParams, $queryParams));

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
                    Url::toRoute(['/catalog/factory-catalogs-files/create']),
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

                            <?php if (!empty($dataProvider->models)) {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $filter,
                                    'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                                    'filterUrl' => Url::toRoute(['/catalog/factory-catalogs-files/list']),
                                    'columns' => [
                                        [
                                            'attribute' => 'title',
                                            'value' => 'title',
                                            'label' => Yii::t('app', 'Title'),
                                            'value' => function ($model) {
                                                /** @var $model FactoryCatalogsFiles */
                                                return Html::a(
                                                    $model->file_link,
                                                    $model->getFileLink(),
                                                    ['target' => '_blank']
                                                );
                                            },
                                            'format' => 'raw',
                                            'filter' => false,
                                        ],
                                        [
                                            'attribute' => 'updated_at',
                                            'value' => function ($model) {
                                                /** @var $model FactoryCatalogsFiles */
                                                return date('j.m.Y H:i', $model->updated_at);
                                            },
                                            'format' => 'raw',
                                            'filter' => false
                                        ],
                                        [
                                            'attribute' => 'published',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                /** @var $model FactoryCatalogsFiles */
                                                return ($model->published) ? 1 : 0;
                                            },
                                            'headerOptions' => ['class' => 'col-sm-1',],
                                            'contentOptions' => ['class' => 'text-center',],
                                        ],
                                        [
                                            'class' => yii\grid\ActionColumn::class,
                                            'template' => '{update} {delete}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    /** @var $model FactoryCatalogsFiles */
                                                    return (empty($model->product))
                                                        ? Html::a(
                                                            '<span class="glyphicon glyphicon-pencil"></span>',
                                                            Url::toRoute([
                                                                '/catalog/factory-catalogs-files/update',
                                                                'id' => $model['id']
                                                            ]),
                                                            [
                                                                'class' => 'btn btn-default btn-xs'
                                                            ]
                                                        )
                                                        : '';
                                                },
                                                'delete' => function ($url, $model) {
                                                    /** @var $model FactoryCatalogsFiles */
                                                    return (empty($model->product))
                                                        ? Html::a(
                                                            '<span class="glyphicon glyphicon-trash"></span>',
                                                            Url::toRoute([
                                                                '/catalog/factory-catalogs-files/intrash',
                                                                'id' => $model['id']
                                                            ]),
                                                            [
                                                                'class' => 'btn btn-default btn-xs',
                                                                'data-confirm' => Yii::t(
                                                                    'yii',
                                                                    'Are you sure you want to delete this item?'
                                                                ),
                                                            ]
                                                        )
                                                        : '';
                                                },
                                            ],
                                            'buttonOptions' => ['class' => 'btn btn-default btn-xs'],
                                            'headerOptions' => ['class' => 'col-sm-1',],
                                        ],
                                    ],
                                ]);
                            } ?>

                            <div><?= Yii::t('app', 'Что бы изменить или удалить размещенные каталоги - обратитесь к администратору проекта.') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
