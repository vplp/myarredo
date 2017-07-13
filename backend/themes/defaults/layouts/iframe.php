<?php

use yii\helpers\Html;
//
use backend\widgets\LangSwitch\LangSwitch;
use backend\themes\defaults\assets\AppAsset;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
$bundle = AppAsset::register($this);

$this->beginPage()
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <base href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>">
    <meta charset="<?= Yii::$app->charset ?>"/>
    <link rel="shortcut icon" type="image/png" href="shortfavicon.png"/>
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->head(); ?>
</head>
<body class="html">
<?php $this->beginBody() ?>

<div id="wrapper">
    <div id="page-wrapper" class="white-bg" style="margin-left: 0; padding: 0 0 0 0;">
        <div class="row border-bottom" style="height: 0; overflow: hidden;">
            <nav class="navbar navbar-static-top gray-bg" role="navigation" style="margin-bottom: 0">
                <?= LangSwitch::widget() ?>
            </nav>
        </div>
        <?= $content; ?>
    </div>
</div>

<style>
    .ibox-content {
        padding: 0 0 0 0;
    }
</style>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
