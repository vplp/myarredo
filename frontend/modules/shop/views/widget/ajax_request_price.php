<?php

use frontend\modules\shop\widgets\request\RequestPrice;

?>

<h3><?= Yii::t('app', 'Заполните форму - получите лучшую цену на этот товар') ?></h3>
<?= RequestPrice::widget(['product_id' => $product_id]) ?>
