<?php

use frontend\themes\myarredo\assets\AppAsset;
use frontend\themes\myarredo\widgets\Alert;

$bundle = AppAsset::register($this);

$this->beginPage()

?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <base href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= $this->title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php $this->head(); ?>
        <input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
        <![endif]-->
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?= Alert::widget() ?>

    <?= $this->render('parts/_header', ['bundle' => $bundle]) ?>

    <?= $content ?>

    <?= $this->render('parts/_footer', []) ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>