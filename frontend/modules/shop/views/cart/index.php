<?php

use yii\helpers\{
    Html, Url
};

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::tag('h2', $this->context->title) ?>

                    <?= Html::a('Добавить товар', Url::toRoute(['/catalog/category/list']), ['class' => 'btn btn-default add-product']) ?>
                </div>
                <div class="col-md-8">

                    <?= \frontend\modules\shop\widgets\cart\Cart::widget(['view' => 'full']) ?>

                </div>
                <div class="col-md-4">
                    <div class="best-price-form">
                        <h3>Заполните форму - получите лучшую цену на этот товар</h3>

                        <?= \frontend\modules\shop\widgets\request\RequestPrice::widget(['view' => 'request_price_form']) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
