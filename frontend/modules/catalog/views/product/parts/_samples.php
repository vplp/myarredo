<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\Samples;

/** @var $samples Samples[] */
/** @var $model Samples */

?>

<div class="container large-container">
    <div class="row">
        <?php foreach ($samples as $model) { ?>
            <div class="col-md-3">
                <?= Html::a(
                    Html::img($model->getImageLink()),
                    $model->getImageLink(),
                    ['class' => 'show-modal']
                ) ?>
            </div>
        <?php } ?>
    </div>
</div>