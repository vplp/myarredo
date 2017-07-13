<?php

use yii\helpers\Html;
//
Yii::$app->metatag->registerModel($model);
//
$this->title = $model['lang']['title'];
?>

    <div class="neck">
        <?= Html::tag('h1', Html::encode($model['lang']['title']), []); ?>
    </div>

<?= $model['lang']['content'] ?>