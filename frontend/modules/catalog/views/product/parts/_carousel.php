<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<div id="prod-slider" class="carousel slide carousel-fade" data-ride="carousel">

    <!-- Carousel items -->
    <div class="carousel-inner">

        <?php foreach ($model->getGalleryImage() as $key => $src) {

            $class = 'item' . (($key == 0) ? ' active' : '');

            echo Html::beginTag('div', ['class' => $class]) .
                Html::a(
                    Html::img($src['img'], ['itemprop' => 'image']),
                    $src['img'],
                    [
                        'class' => 'img-cont fancyimage',
                        'data-fancybox-group' => 'group'
                    ]
                ) .
                Html::endTag('div');
        } ?>

    </div>

    <a href="javascript:void(0);" class="img-zoom"><?= Yii::t('app','Увеличить') ?></a>

    <!-- Carousel nav -->

    <div class="nav-cont">

        <a class="left left-arr nav-contr" href="#prod-slider" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>

        <ol class="carousel-indicators">

            <?php foreach ($model->getGalleryImage() as $key => $src): ?>

                <li data-target="#prod-slider" data-slide-to="<?= $key ?>"
                    class="<?= ($key == 0) ?? 'active' ?>">
                    <div class="img-min">
                        <?= Html::img($src['thumb']); ?>
                    </div>
                </li>

            <?php endforeach; ?>

        </ol>

        <a class="right right-arr nav-contr" href="#prod-slider" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>

    </div>

</div>