<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

$module = (Yii::$app->controller->module->module->id == "app-backend") ?
    Yii::$app->controller->module->id : Yii::$app->controller->module->module->id;

$this->beginContent('@app/layouts/main.php'); ?>

<div class="header-content">
    <div class="row">
        <div class="col-md-9">
            <i class="fa fa-file"></i>
            <?= Yii::t($module, $this->context->module->title) ?>.
            <?= Yii::t($module, $this->context->title) ?>
        </div>
    </div>
</div>

<div class="body-content animated fadeIn" style="min-height: 600px;">
    <div class="col-md-12">
        <div class="panel rounded shadow">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>
