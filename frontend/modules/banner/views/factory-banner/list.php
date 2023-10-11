<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 * @var \frontend\modules\banner\models\BannerItem $model
 */

$dataProvider = $model->search(Yii::$app->request->queryParams);
$dataProvider->sort = false;

$this->title = $this->context->title;

?>

<main>
    <div class="page factory-profile">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">

                <?= Html::a(Yii::t('app', 'Create'), Url::toRoute(['/banner/factory-banner/create']), ['class' => 'btn btn-default']) ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'headerOptions' => ['class' => 'col-sm-1',],
                        ],
                        'lang.title',
                        [
                            'attribute' => 'position',
                            'headerOptions' => ['class' => 'col-sm-1',],
                        ],
                        [
                            'attribute' => 'published',
                            'format' => 'raw',
                            'value' => function ($model) {
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
                                    return Html::a(
                                        '<i class="fa fa-pencil" aria-hidden="true"></i>',
                                        Url::to(['/banner/factory-banner/update', 'id' => $model->id]),
                                        ['class' => 'btn btn-default btn-xs']
                                    );
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a(
                                        '<i class="fa fa-trash" aria-hidden="true"></i>',
                                        Url::to(['/banner/factory-banner/intrash', 'id' => $model->id]),
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
                ]) ?>

            </div>
        </div>
    </div>
</main>
