<?php

use yii\helpers\Html;

$this->title = $name;

?>

<h1><?= $exception->statusCode ?></h1>
<h3 class="font-bold"><?= Html::encode($this->title) ?></h3>

<div class="error-desc">
    <?= nl2br(Html::encode($message)) ?>
</div>
