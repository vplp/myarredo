<?php

use yii\helpers\Url;

?>

<a href="<?= Url::toRoute(['/shop/cart/notepad']) ?>" class="my-notebook wishlist" rel="nofollow" title="<?= Yii::t('app', 'My notebook') ?>">
    <span class="red-but">
        <i class="fa fa-heart-o" aria-hidden="true"></i>
    </span>
    <span class="inscription"> <span class="for-price"></span></span>
</a>