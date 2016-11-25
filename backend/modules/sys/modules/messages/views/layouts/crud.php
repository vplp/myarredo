<?php

use yii\helpers\{
    ArrayHelper, Html
};

?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>
            <?= Yii::t($this->context->module->name, $this->context->module->title) ?>.
            <?= Yii::t($this->context->module->name, $this->context->title) ?>.
        </h2>
    </div>
    <div class="col-lg-2" style="text-align: right;">
        <h2>
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Update files'), ['updatefiles'], ['class' => 'btn btn-warning']) ?>
        </h2>
    </div>
    <div class="col-lg-1" style="text-align: right;">
        <h2>
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Fill'), ['fill'], ['class' => 'btn btn-warning']) ?>
        </h2>
    </div>
    <div class="col-lg-3" style="text-align: right;">
        <h2>
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), ArrayHelper::merge(['create'], Yii::$app->getRequest()->get()), ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-trash"></i> ', ArrayHelper::merge(['trash'], Yii::$app->getRequest()->get()), ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Trash')]) ?>
        </h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
