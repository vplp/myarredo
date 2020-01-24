<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\shop\models\Cart $cart
 */

?>

<a href="<?= Url::toRoute(['/shop/cart/notepad']) ?>" class="my-notebook wishlist">
    <span class="red-but">
        <i class="fa fa-heart" aria-hidden="true"></i>
    </span>
    <span class="inscription"><?= Yii::t('app', 'My notebook') ?>: <span class="for-price"><?= count($cart['items']); ?></span></span>
</a>