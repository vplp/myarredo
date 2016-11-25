<?php

use backend\themes\inspinia\assets\AppAsset;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
$bundle = AppAsset::register($this);

$this->beginPage()
?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>">
<head>
    <base href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>">
    <meta charset="<?= Yii::$app->charset ?>"/>
    <link rel="shortcut icon" type="image/png" href="shortfavicon.png"/>
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->head(); ?>
</head>
<style>
    body {
        background-color: #fff !important;
    }
</style>
<body class="html">
<?php $this->beginBody() ?>

<div id="wrapper">
    <div class="gray-bg" style="margin-left: 0;">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
