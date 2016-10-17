<?php

use yii\helpers\Html;
//
use yii\helpers\ArrayHelper;

?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= $this->context->title ?></h2>
    </div>
    <div class="col-lg-2">
        <h2 class="btn-group" >
            <?= Html::a('<i class="fa fa-plus"></i> ' . 'Back', ArrayHelper::merge(['update'], Yii::$app->getRequest()->get()), ['class' => 'btn btn-primary']) ?>
        </h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
