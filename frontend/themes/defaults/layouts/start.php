<?php
/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
$this->beginContent('@app/layouts/main.php');
?>
<!-- ONE COLUMN STRUCTURE START -->
<div class="wrap h clear body-one content-panel">
    <!-- CENTER COLUMN -->
    <section class="column-center r h">

        <?= $content; ?>

    </section>
    <!-- CENTER COLUMN END-->

</div>
<!-- ONE COLUMN STRUCTURE END -->
<?php
$this->endContent();
