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
    <?= backend\themes\defaults\widgets\navbar\NavBar::widget(['bundle' => $bundle]); ?>
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top gray-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <?= Html::a('<i class="fa fa-sign-out"></i>', ['/user/logout']) ?>
                    </li>
                </ul>
                <?= LangSwitch::widget() ?>
            </nav>
        </div>
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
