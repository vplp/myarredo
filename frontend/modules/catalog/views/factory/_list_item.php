<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Factory;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 */

?>

<?= Html::beginTag('a', ['href' => Factory::getUrl($model['alias']), 'class' => 'factory-tile']); ?>

    <div class="flex">
        <div class="logo-img">
            <?= Html::img(Factory::getImage($model['image_link'])); ?>
        </div>
        <h3><?= $model['lang']['title']; ?></h3>
    </div>
    <object>
        <ul class="assortment">
            <?php foreach ($categories as $item): ?>
                    <li>
                        <?= Html::a(
                            $item['title'],
                            Yii::$app->catalogFilter->createUrl('factory', $model['alias'], true)
                        ); ?>
                    </li>
            <?php endforeach; ?>

        </ul>
    </object>

<?= Html::endTag('a'); ?>