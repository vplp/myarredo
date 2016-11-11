<?php

use yii\helpers\Html;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
?>

<div class="card cf">

    <?php if ($product->is_bestseller): ?>
        <div class="card_hit">Хит продаж</div>
    <?php endif; ?>

    <?php if ($product->is_novelty): ?>
        <div class="card_novelty">Новинка</div>
    <?php endif; ?>

    <div class="card_l">
        <a href="<?= $product->getUrl() ?>" class="card_img">
            <?php if ($product->getImageLink()): ?>
                <img src="<?= $product->getImageLink() ?>">
            <?php endif; ?>
        </a>
    </div>
    <div class="card_r">
        <?= Html::a(Html::encode($product['lang']['title']), $product->getUrl(), ['class' => 'card_t']) ?>
        <div class="card_tx"><?= $product['lang']['description'] ?></div>
        <div class="card_b cf">
            <div class="card_b_l">
                <div class="card-price"><?= $product['price_of_retail'] ?> <span>грн</span></div>
            </div>
            <div class="card_b_r">
                <button class="card-buy button-green">
                    <i></i>
                    <span>Купить</span>
                </button>
            </div>
        </div>
    </div>
</div>