<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<article class="item" data-key="<?= $model->id; ?>">
    <h2 class="title">
        <?= Html::a(Html::encode($model->lang->title), Url::toRoute(['/banner/factory-banner/update', 'id' => $model->id]), ['title' => $model->lang->title]) ?>
        <?= Html::a('Удалить', Url::toRoute(['/banner/factory-banner/intrash', 'id' => $model->id]), ['class' => 'btn btn-default']) ?>
    </h2>
</article>