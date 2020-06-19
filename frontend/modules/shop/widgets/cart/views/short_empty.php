<?php

use yii\helpers\Url;

?>

<a href="<?= Url::toRoute(['/shop/cart/notepad']) ?>" class="my-notebook wishlist" rel="nofollow">
    <span class="red-but">
        <i class="fa fa-heart" aria-hidden="true"></i>
    </span>
    <span class="inscription"><span class="for-nt-text"><?= Yii::t('app', 'My notebook') ?></span> <span class="for-price"></span></span>
</a>