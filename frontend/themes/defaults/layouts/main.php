<?php

use frontend\themes\defaults\assets\AppAsset;
//
use frontend\modules\menu\widgets\menu\Menu;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
AppAsset::register($this);

$this->beginPage()
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <base href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= $this->title ?></title>
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
                <?= Menu::widget() ?>
            </div>
        </header>
        <!-- HEADER END-->
        <div class="container">
            <?= $content ?>
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