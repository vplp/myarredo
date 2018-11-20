<?php

use yii\helpers\Html;

?>

<div class="newsbox-item">
    <div class="newsbox-item-title"><?= Html::encode($article['lang']['title']) ?></div>
    <div class="newsbox-item-descr"><?= $article['lang']['description'] ?></div>
    <div class="newsbox-item-more">
        <?php if ($article['lang']['content'] !== '') { ?>
            <?= Html::a(Yii::t('app', 'Подробнее'), $article->getUrl(), ['class' => 'btn-descr']) ?>
        <?php } ?>
    </div>
</div>