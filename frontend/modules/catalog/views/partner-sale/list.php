<?php

use yii\helpers\{
    Html, Url
};
use yii\grid\GridView;
use frontend\components\Breadcrumbs;

/**
 * @var \yii\data\Pagination $pages
 * @var $model \frontend\modules\catalog\models\Sale
 */

$dataProvider = $model->search(Yii::$app->request->queryParams);
$dataProvider->sort = false;

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row">

                <?= Html::tag('h1', $this->context->title); ?>

                <?= Html::a('Добавить товар распродажи', Url::toRoute(['/partner/sale/create']), ['class' => 'btn btn-default']) ?>

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>

            </div>
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'attribute' => 'lang.title',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Sale */
                                            return $model->getTitle();
                                        },
                                    ],
                                    [
                                        'attribute' => 'factory_id',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Sale */
                                            return ($model['factory']) ? $model['factory']['title'] : $model['factory_name'];
                                        },
                                    ],
                                    [
                                        'attribute' => 'published',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Sale */
                                            return ($model->published) ? 1 : 0;
                                        },
                                        'headerOptions' => ['class' => 'col-sm-1',],
                                        'contentOptions' => ['class' => 'text-center',],
                                    ],
                                    [
                                        'label' => 'Просмотры товара',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Sale */
                                            return 0;
                                        },
                                    ],
                                    [
                                        'label' => 'Запрос телефона',
                                        'value' => function ($model) {
                                            /** @var $model \frontend\modules\catalog\models\Sale */
                                            return 0;
                                        },
                                    ],
                                    [
                                        'class' => yii\grid\ActionColumn::class,
                                        'template' => '{update} {delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\Sale */
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    Url::toRoute(['/catalog/partner-sale/update', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs'
                                                    ]
                                                );
                                            },
                                            'delete' => function ($url, $model) {
                                                /** @var $model \frontend\modules\catalog\models\Sale */
                                                return Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    Url::toRoute(['/catalog/partner-sale/intrash', 'id' => $model->id]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs',
                                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    ]
                                                );
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
