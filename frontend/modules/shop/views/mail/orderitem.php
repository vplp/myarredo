<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
$extra_param = (array) json_decode($article['extra_param']);
?>
<tr class="tr">
    <td class="td product_img">
        <img style="width: 100px;" alt="<?= Html::encode($article['item']['lang']['title']); ?>" src="<?= 'http://www.nashstyle.com.ua/' . $article['item']->getImageUrl(); ?>">
    </td>
    <td class="td product_details">
        <div class="product_main_details">
            <div class="articule">APT <?= $article['item']['marking']; ?></div>
            <h3 class="product_name"><?= $article['item']['lang']['title']; ?></h3>
            <?php if (isset($extra_param['size'])): ?>
                <div class="size_block">
                    <span class="label">Размер:</span>
                    <span class="size"><?= $extra_param['size'] ?></span>
                </div>
            <?php endif; ?>
        </div>
    </td>
    <td class="td product_count">
        <?= $article['count']; ?>
    </td>
    <td class="td product_status">
        <?= $article['item']->statusOnStockRangeLabel(); ?>
    </td>
    <td class="td product_cost">
        <div class="price-container">
            <span itemprop="price" class="actual-price"><?= $article['price']; ?></span>
            <span class="currency">грн</span>
        </div>
    </td>
    <td class="td summ">
        <div class="price-container">
            <span class="summ actual-price"><?= $article['price'] * $article['count']; ?></span>
            <span class="currency">грн</span>
        </div>
    </td>
</tr>