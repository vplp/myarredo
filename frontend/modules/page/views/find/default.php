<?php

use yii\helpers\Html;

$this->title = $model['lang']['title'];
?>

        <div class="neck">
            <?= Html::tag('h1', Html::encode($model['lang']['title']), []); ?>
        </div>

    </div>
</div>
<div class="policy clearfix">
    <div class="policy-body">

        <?= $model['lang']['content'] ?>