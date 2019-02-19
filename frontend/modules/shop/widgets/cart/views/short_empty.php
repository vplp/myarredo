<?php

use yii\helpers\Url;

?>

<a href="<?= Url::toRoute(['/shop/cart/notepad']) ?>" class="my-notebook wishlist" rel="nofollow">
    <span class="red-but">
        <i class="fa fa-heart" aria-hidden="true"></i>
    </span>
    <span class="inscription"><?= Yii::t('app', 'My notebook') ?> <span class="for-price"></span></span>
</a>