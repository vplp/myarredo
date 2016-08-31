<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

use yii\widgets\Breadcrumbs;

?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>
            <?= Yii::t($this->context->module->name, $this->context->module->title) ?>.
            <?= Yii::t($this->context->module->name, $this->context->title) ?>.
            <?= Yii::t('app', 'Update') ?>
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
                Yii::t('app', 'Update'),
            ],
        ]) ?>
    </div>

    <div class="wrapper wrapper-content animated fadeIn">
        <?= $content; ?>
    </div>

    <?php $this->endContent(); ?>
