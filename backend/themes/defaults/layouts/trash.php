<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>
            <?= Yii::t($this->context->module->name, $this->context->module->title) ?>.
            <?= Yii::t($this->context->module->name, $this->context->title) ?>.
            <?= Yii::t('app', 'Trash') ?>
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
                Yii::t('app', 'Trash'),
            ],
        ]) ?>
    </div>
    <div class="col-lg-2">
        <h2 class="btn-group" role="group">
            <?= Html::a('<i class="fa fa-list"></i> ' . Yii::t('app', 'Back to list'), ['list'], ['class' => 'btn btn-primary']) ?>
        </h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
