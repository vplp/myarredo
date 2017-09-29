<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\data\Pagination $pages
 * @var \frontend\modules\catalog\models\Sale $model
 */

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row">
                <?= Html::tag('h1', $this->context->title); ?>

                <?= Html::a('Добавить товар распродажи', Url::toRoute(['/partner/sale/create']), ['class' => 'btn btn-default']) ?>

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                    'options' => ['class' => 'bread-crumbs']
                ]) ?>
            </div>
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area">

                            <div class="cat-prod-wrap">
                                <div class="cat-prod">

                                    <?php if (!empty($models)): ?>
                                        <?php foreach ($models as $model): ?>
                                            <?= $this->render('_list_item', ['model' => $model]) ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Не найдено</p>
                                    <?php endif; ?>

                                </div>
                                <div class="pagi-wrap">

                                    <?=
                                    yii\widgets\LinkPager::widget([
                                        'pagination' => $pages,
                                        'registerLinkTags' => true,
                                        'nextPageLabel' => 'Далее<i class="fa fa-angle-right" aria-hidden="true"></i>',
                                        'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>Назад'
                                    ]);
                                    ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
