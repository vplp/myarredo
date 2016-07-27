<?php

use backend\themes\inspinia\assets\AppAsset;


/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
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
        <?= backend\themes\inspinia\widgets\menu\NavBar::widget(['bundle' => $bundle]); ?>
        <div id="page-wrapper" class="gray-bg">
            <?= $this->render('parts/_header', ['bundle' => $bundle]) ?>
                <?= $content; ?>
            <div class="footer">
                <div>
                    <strong>Copyright</strong> VipDesign &copy; <?= date('Y') ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
