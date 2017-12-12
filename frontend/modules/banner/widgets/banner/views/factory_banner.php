<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\banner\models\BannerItem $model
 */

?>

<?php if (!empty($items)): ?>

    <div class="fact-slider">

        <?php foreach ($items as $model): ?>

            <div class="img-cont">
                <?php if ($model['lang']['link'] != ''): ?>
                    <?= Html::a(Html::img($model->getImageLink()), $model['lang']['link'], []); ?>
                <?php else: ?>
                    <?= Html::img($model->getImageLink()); ?>
                <?php endif; ?>
                <span><?= $model['lang']['title']; ?></span>
            </div>

        <?php endforeach; ?>

    </div>

<?php
$script = <<<JS
$('.fact-slider').slick({
    autoplay: true,
    dots: true,
    arrows: false,
    fade: true,
    cssEase: 'linear',
    autoplaySpeed: 3000
});
JS;

$this->registerJs($script, yii\web\View::POS_END);
?>

<?php endif; ?>