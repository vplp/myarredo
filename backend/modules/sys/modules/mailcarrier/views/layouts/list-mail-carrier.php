<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
use yii\helpers\Html;

$this->beginContent('@app/layouts/main.php'); ?>

    <div class="row border-bottom white-bg page-heading">
        <div class="col-md-7">
            <h2>
                <?= Yii::t('sys', $this->context->module->title) ?>.
                <?= Yii::t('sys', $this->context->module->title) ?>.
                <?= Yii::t('app', 'List') ?>
            </h2>
        </div>
        <div class="col-md-2">
            <h2 class="btn-group" role="group">
                <?= Html::a(Yii::t('sys', 'MailBox'), ['/sys/mail-carrier/mail-box/list'], ['class' => 'btn btn-warning']) ?>
            </h2>
        </div>
        <div class="col-md-3">
            <h2 class="btn-group" role="group">
                <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-trash"></i> ', ['trash'], ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Trash')]) ?>
            </h2>
        </div>
    </div>

    <div class="animated fadeIn">
        <?= $content ?>
    </div>

<?php $this->endContent();
