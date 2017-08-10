<?php

use yii\helpers\Html;

/**
 * @var $model \frontend\modules\catalog\models\Factory
 */

?>

<div class="popular-fabr">
    <div class="container large-container">
        <div class="row">
            <h2>Популярные итальянские фабрики</h2>
            <div class="fabr-cont">

                <?php foreach ($models as $model): ?>
                    <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                        <?= Html::beginTag('a', ['href' => $model->getUrl()]); ?>
                        <div class="img-cont"><?= Html::img($model->getImageLink()); ?></div>
                        <div class="descr"><?= $model['lang']['title']; ?></div>
                        <?= Html::endTag('a'); ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
