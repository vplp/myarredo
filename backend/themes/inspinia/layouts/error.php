<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
use yii\helpers\Html;

$this->beginContent('@app/layouts/main.php'); ?>
        <div class="site-error">
            <?= $content ?>
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="alert alert-danger">
                <?= nl2br(Html::encode($message)) ?>
            </div>
        </div>
<?php $this->endContent(); ?>
