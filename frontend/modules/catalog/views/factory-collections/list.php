<?php

use yii\helpers\{
    Html, Url
};
use yii\grid\GridView;
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\Collection;

/**
 * @var \yii\data\Pagination $pages
 * @var $model Collection
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
                        <div class="cont-area cont-goods">

                            <?php if (!empty($dataProvider->models)) { ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => false,
                                    'layout' => "{summary}\n{items}\n<div class=\"pagi-wrap\">{pager}</div>",
                                    'filterUrl' => Url::toRoute(['/catalog/factory-collections/list']),
                                    'columns' => [
                                        [
                                            'attribute' => 'title',
                                            'value' => 'title',
                                            'label' => Yii::t('app', 'Title'),
                                        ],
                                        [
                                            'attribute' => 'year',
                                            'value' => function ($model) {
                                                /** @var $model Collection */
                                                return $model->year > 0 ? $model->year : '';
                                            },
                                        ],
                                        [
                                            'class' => yii\grid\ActionColumn::class,
                                            'template' => '{update}',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    /** @var $model Collection */
                                                    return (Yii::$app->user->identity->id == $model['user_id'])
                                                        ? Html::a(
                                                            '<i class="fa fa-pencil" aria-hidden="true"></i>',
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
                                ]) ?>
                            <?php } else { ?>
                                <div class="text-center">
                                    <?= Yii::t('app', 'Добавьте коллекции мебели Вашей фабрики.'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
