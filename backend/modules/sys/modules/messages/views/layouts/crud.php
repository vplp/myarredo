<?php

use yii\helpers\{
    Html
};

?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<div class="row border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>
            <?= Yii::t($this->context->module->name, $this->context->module->title) ?>.
            <?= Yii::t($this->context->module->name, $this->context->title) ?>.
        </h2>
    </div>
    <div class="col-lg-1" style="text-align: right;">
        <h2>
            <?= Html::a('<i class="fa fa-plus"></i> 1 ' . Yii::t('messages', 'Fill'), ['fill'], ['class' => 'btn btn-warning']) ?>
        </h2>
    </div>
    <div class="col-lg-2" style="text-align: right;">
        <h2>
            <?= Html::a('<i class="fa fa-plus"></i> 2 ' . Yii::t('messages', 'Update files'), ['updatefiles'], ['class' => 'btn btn-warning']) ?>
        </h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
