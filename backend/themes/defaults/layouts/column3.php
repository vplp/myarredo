<?php

use yii\helpers\Html;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
$this->beginContent('@app/layouts/base.php');
?>
<!-- THREE COLUMN STRUCTURE START -->
<div class="wrap h clear body-three">
    <!-- LEFT COLUMN -->
    <aside class="column-left fl">
        LEFT COLUMN
    </aside>
    <!-- LEFT COLUMN END-->

    <!-- RIGHT COLUMN -->
    <aside class="column-right fr">
        RIGHT COLUMN
    </aside>
    <!-- RIGHT COLUMN END-->

    <!-- CENTER COLUMN -->
    <section class="column-center r h">
        <h1 class="rtext" style="display: block;"><?= Html::encode($this->title) ?></h1>

        <div class="container">
            <?= $content ?>
        </div>

    </section>
    <!-- CENTER COLUMN END-->
</div>
<!-- THREE COLUMN STRUCTURE END -->
<?php
$this->endContent();
