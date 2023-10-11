<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<div class="row border-bottom white-bg page-heading">
    <div class="col-md-7">
        <h2>
            <?= Yii::t($this->context->module->name, $this->context->module->title) ?>.
            <?= Yii::t('app', 'Groups') ?>
        </h2>
        <?= Breadcrumbs::widget([
            'homeLink' => false,
            'links' => [
                [
                    'label' => Yii::t($this->context->module->name, $this->context->module->title),
                ],
                [
                    'label' => Yii::t('app', 'Groups'),
                ],
                Yii::t('app', 'List'),
            ],
        ]) ?>
    </div>
    <div class="col-md-2">
        <h2 class="btn-group" role="group">
            <?= Html::a(Yii::t('app', 'User'), ['/user/user/list'], ['class' => 'btn btn-warning']) ?>
        </h2>
    </div>
    <div class="col-md-3">
        <h2 class="btn-group" role="group">
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-trash"></i> ', ['trash'], ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Trash')]) ?>
        </h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
