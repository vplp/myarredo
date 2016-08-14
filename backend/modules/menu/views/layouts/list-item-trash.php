<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
        <!--        <ol class="breadcrumb">-->
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
        <h2>
            <?= Html::a(
                '<i class="fa fa-list"></i> ' . 'Back to list',
                [
                    'list',
                    'group_id' => $this->context->group->id??null,
                    'parent_id' => $this->context->parent->id??null
                ],
                ['class' => 'btn btn-primary']
            ) ?>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <?= $content; ?>
</div>


<?php $this->endContent(); ?>
