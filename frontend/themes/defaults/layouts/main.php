<?php

//use Yii;
use frontend\themes\defaults\assets\AppAsset;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
AppAsset::register($this);

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

    <div class="wrapper clear r">
        <!-- HEADER -->
        <header>
            <div class="wrap r h clear panel">
                HEADER
            </div>
        </header>
        <!-- HEADER END-->
        <div class="container">
            <?= $content ?>
            <?= Yii::$app->getModule('configs')->getParam(1)?>
        </div>

    </div>

    <!-- FOOTER -->
    <footer>
        <div class="wrap h clear">
            <div class="copy">
                Все права защищены.<br/>
            </div>
        </div>
    </footer>
    <!-- FOOTER END-->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>