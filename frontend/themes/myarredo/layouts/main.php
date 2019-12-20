<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\widgets\Alert;
use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= substr(Yii::$app->language, 0, 2) ?>">
    <head>
        <base href="<?= Yii::$app->getRequest()->hostInfo . Url::toRoute(['/']) ?>">

        <meta charset="<?= Yii::$app->charset ?>"/>

        <title><?= $this->title ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noyaca"/>

        <?php $this->head(); ?>
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" type="text/javascript"
                charset="UTF-8"></script>
        <![endif]-->
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?= Alert::widget() ?>

    <?= $this->render('parts/_header', ['bundle' => $bundle]) ?>

    <div class="fone-poster-box" style="background-color:#000000;">
        <div class="fone-poster-left">
            <a href="#" class="fone-poster-link">
                <img src="https://wine-mag.ru/wp-content/uploads/2018/12/Molto-Buono-2.0-960x1200.jpg" alt="мебель в Италии">
            </a>
        </div>
        <div class="fone-poster-right">
            <a href="#" class="fone-poster-link">
                <img src="http://d14.cdn.braun634.com/uploads/media/1/8/27181/v1/right_bg.jpg" alt="мебель в Италии">
            </a>
        </div>
    </div>

    <?= $content ?>

    <?= $this->render('parts/_footer', []) ?>

    <?= $this->render('parts/_jivosite', []) ?>

    <?= $this->render('parts/_yandex_metrika', []) ?>

    <?= $this->render('parts/_google_metrika', []) ?>

    <input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">

    <?php $this->endBody() ?>

    </body>
    </html>
<?php $this->endPage() ?>