<?php

use yii\helpers\{
    Html, Url
};
use frontend\components\Breadcrumbs;

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
                ]) ?>

            </div>
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area">

                            <div class="cat-prod-wrap">
                                <div class="cat-prod">

                                    <?php
                                    if (!empty($models)) {
                                        foreach ($models as $model) {
                                            echo $this->render('_list_item', ['model' => $model]);
                                        }
                                    } else {
                                        echo '<p>Не найдено</p>';
                                    } ?>

                                </div>
                                <div class="pagi-wrap">

                                    <?= frontend\components\LinkPager::widget([
                                        'pagination' => $pages,
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
