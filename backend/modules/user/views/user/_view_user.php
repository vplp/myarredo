<?php

use thread\modules\sanatorium\models\Sanatoriums;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use admin\modules\user\models\Group;
use thread\app\components\HtmlForm;
use admin\modules\company\models\Company;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
$form = ActiveForm::begin();

$profile = $model['profile'];
?>


<div class="row form-group">
    <div class="col-sm-2">
            <?= Html::activeLabel($model, 'username'); ?>
    </div>
    <div class="col-sm-10">
        <p class="form-control"  style="width:100%"> <?= $model->username ?>  </p>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-2">
        <?= Html::activeLabel($model, 'email'); ?>
    </div>
    <div class="col-sm-10">
        <p class="form-control"  style="width:100%"> <?= $model->email ?>  </p>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-2">
        <?= Html::activeLabel($model, 'name'); ?>
    </div>
    <div class="col-sm-10">
        <p class="form-control"  style="width:100%"> <?= $model->profile->name ?>  </p>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-2">
        <?= Html::activeLabel($model, 'surname'); ?>
    </div>
    <div class="col-sm-10">
        <p class="form-control"  style="width:100%"> <?= $model->profile->surname ?>  </p>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-2">
        <?= Html::activeLabel($model, 'group_id'); ?>
    </div>
    <div class="col-sm-10">
        <p class="form-control"  style="width:100%">
            <?= isset($model->group->lang->title) ? $model->group->lang->title : '' ?>
        </p>

    </div>
</div>

<div class="row form-group">
    <div class="col-sm-2">
        <?= Html::activeLabel($model, 'sanatorium_id'); ?>
    </div>
    <div class="col-sm-10">
        <p class="form-control"  style="width:100%">
            <?= isset($model->sanatorium->lang->title) ? $model->sanatorium->lang->title : '' ?>  </p>
    </div>
</div>

<div class="row form-group">
    <a href="<?= $backLink ?>" class="btn btn-success pull-right "> <?= Yii::t('app', 'action_back')?> </a>
</div>

<?php
ActiveForm::end();
