<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\shop\widgets\cart\Cart;
use frontend\modules\shop\widgets\request\RequestPrice;

$this->title = $this->context->title;

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::tag('h2', $this->context->title) ?>

                    <?= Html::a(
                        Yii::t('app', 'Добавить товар'),
                        Url::toRoute(['/catalog/category/list']),
                        ['class' => 'btn btn-default add-product']
                    ) ?>
                </div>

                <?php if (!empty(Yii::$app->shop_cart->items)) { ?>
                    <div class="col-md-8">

                        <?= Cart::widget(['view' => 'full']) ?>

                    </div>
                    <div class="col-md-4">
                        <div class="best-price-form">
                            <h3><?= Yii::t('app', 'Заполните форму - получите лучшую цену на этот товар') ?></h3>

                            <?= RequestPrice::widget(
                                ['view' => 'request_price_form_notepad']
                            ) ?>

                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-12">
                        <p><?= Yii::t('app', 'Вы еще не добавили в блокнот товаров.') ?></p>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</main>
