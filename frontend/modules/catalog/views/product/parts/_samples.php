<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Samples;

/** @var $samples Samples[] */
/** @var $model Samples */

?>

<div class="container large-container">
    <div class="row">
        <?php foreach ($samples as $model) { ?>
            <div class="col-md-3">
                <?= Html::a(
                    Html::img(Samples::getImageThumb($model['image_link']), ['loading' => 'lazy']),
                    Samples::getImage($model['image_link']),
                    ['class' => 'show-modal']
                ) ?>
            </div>
        <?php } ?>
    </div>
</div>
