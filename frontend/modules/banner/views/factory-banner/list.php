<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

?>

<main>
    <div class="page factory-profile">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">

                <?= Html::a('Добавить', Url::toRoute(['/banner/factory-banner/create']), ['class' => 'btn btn-default']) ?>


                <?= GridView::widget([
                    'dataProvider' => $model->search(Yii::$app->request->queryParams),
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
                                        '<span class="glyphicon glyphicon-pencil"></span>',
                                        Url::to(['/banner/factory-banner/update', 'id' => $model->id]),
                                        ['class' => 'btn btn-default btn-xs']
                                    );
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a(
                                        '<span class="glyphicon glyphicon-trash"></span>',
                                        Url::to(['/banner/factory-banner/intrash', 'id' => $model->id]),
                                        ['class' => 'btn btn-default btn-xs']
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
</main>
