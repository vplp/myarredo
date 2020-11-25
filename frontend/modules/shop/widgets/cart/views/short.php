<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\shop\models\Cart $cart
 */

?>

<a href="<?= Url::toRoute(['/shop/cart/notepad']) ?>" class="my-notebook wishlist" title="<?= Yii::t('app', 'My notebook') ?>">
    <span class="red-but">
        <i class="fa fa-heart" aria-hidden="true"></i>
    </span>
    <span class="inscription"><span class="for-nt-arr"></span> <span class="for-price"><?= count($cart['items']); ?></span></span>
</a>