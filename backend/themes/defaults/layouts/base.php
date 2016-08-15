<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<!--    TODO: Заменить виджетом breadcrumbs    -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= $this->context->getTitle() ?></h2>
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
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
