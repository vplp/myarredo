<?php

use yii\helpers\Url;

?>

<a href="<?= Url::toRoute(['/shop/cart/notepad']) ?>" class="my-notebook">
    <span class="red-but">
        <i class="fa fa-heart" aria-hidden="true"></i>
    </span>
    <span class="inscription">Мой блокнот</span>
</a>