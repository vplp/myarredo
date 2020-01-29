<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<div class="row border-bottom white-bg page-heading">
    <div class="col-md-7">
        <h2>
            <?= Yii::t($this->context->module->name, $this->context->module->title) ?>.
            <?= Yii::t($this->context->module->name, $this->context->title) ?>
        </h2>
        <?= Breadcrumbs::widget([
            'homeLink' => false,
            'links' => [
                [
                    'label' => Yii::t($this->context->module->name, $this->context->module->title),
                ],
                [
                    'label' => Yii::t($this->context->module->name, $this->context->title),
                ],
                Yii::t('app', 'List'),
            ],
        ]) ?>
    </div>

    <div class="col-md-3">
        <h2 class="btn-group" role="group">
            <?= Html::a('<i class="fa fa-trash"></i> ', ['trash'], ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Trash')]) ?>
        </h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
