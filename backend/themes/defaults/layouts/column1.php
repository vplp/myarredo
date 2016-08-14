<?php

//use thread\app\widgets\Nav\Breadcrumbs;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
$this->beginContent('@app/layouts/base.php');
?>
<!-- ONE COLUMN STRUCTURE START -->
<div class="wrap h clear body-one content-panel">
    <!-- CENTER COLUMN -->
    <section class="column-center r h">

        <div class="main-breadcrumbs">
            <?php // Breadcrumbs::widget($this->context->breadcrumbs); ?>
        </div>

        <div class="container">
            <?= $content ?>
        </div>

    </section>
    <!-- CENTER COLUMN END-->
</div>
<!-- ONE COLUMN STRUCTURE END -->
<?php
$this->endContent();
