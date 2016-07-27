<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
use yii\helpers\Html;
use backend\themes\inspinia\assets\AppAsset;

$bundle = AppAsset::register($this);
?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<!--    TODO: Заменить виджетом breadcrumbs    -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= $this->context->title ?></h2>
<!--                <ol class="breadcrumb">-->
        <!--            <li>-->
        <!--                --><?php //= Html::a('Home', ['/']) ?>
        <!--            </li>-->
        <!--            <li>-->
        <!--                <a>*Breadcrumb 1*</a>-->
        <!--            </li>-->
        <!--            <li class="active">-->
        <!--                <strong>*Breadcrumb 2*</strong>-->
        <!--            </li>-->
        <!--        </ol>-->
    </div>
    <div class="col-lg-2">
        <h2 class="btn-group" role="group">
            <?= Html::a('<i class="fa fa-plus"></i> ' . 'Create', [
                'create',
                'group_id' => Yii::$app->getRequest()->get('group_id'),
                'parent_id' => Yii::$app->getRequest()->get('parent_id') ?? null
            ], ['class' => 'btn btn-primary', 'title' => Yii::t('app', 'Trash')]) ?>
            <?= Html::a('<i class="fa fa-trash"></i> ', ['trash', 'group_id' => Yii::$app->getRequest()->get('group_id')], ['class' => 'btn btn-default']) ?>
        </h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
