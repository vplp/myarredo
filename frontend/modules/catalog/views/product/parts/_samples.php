<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Samples $model
 */

?>

<div class="container large-container">
    <div class="row">
        <?php foreach ($samples as $model): ?>
            <div class="col-md-3">
                <?= Html::a(Html::img($model->getImageLink(), ['class' => 'img-cont']), $model->getImageLink()); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>