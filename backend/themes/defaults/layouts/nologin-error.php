<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
use yii\helpers\Html;

$this->beginContent('@app/layouts/nologin.php'); ?>
<?= nl2br(Html::encode($message)) ?>
<?php $this->endContent(); ?>
