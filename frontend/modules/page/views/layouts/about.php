<?php

use frontend\themes\vents\assets\AppAsset;

$bundle = AppAsset::register($this);

$this->beginContent('@app/layouts/main.php');
?>
    <div class="about-wr">

        <?= $this->render('@app/layouts/parts/_header', ['bundle' => $bundle]) ?>

        <div class="about-content">

            <?= $content ?>

        </div>
    </div>

<?php $this->endContent(); ?>