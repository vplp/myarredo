<?php

use yii\helpers\Html;

use frontend\modules\catalog\models\Factory;
/**
 * @var $model \frontend\modules\catalog\models\Factory
 */

?>

<div class="popular-fabr">
    <div class="container large-container">
        <div class="row">
            <h2><?= Yii::t('app', 'Популярные итальянские фабрики') ?></h2>
            <div class="fabr-cont">

                <?php foreach ($models as $model): ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                        <?= Html::beginTag('a', ['href' => Factory::getUrl($model['alias'])]); ?>
                        <div class="img-cont"><?= Html::img(Factory::getImageThumb($model['image_link'])); ?></div>
                        <div class="descr"><?= $model['title']; ?></div>
                        <?= Html::endTag('a'); ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
