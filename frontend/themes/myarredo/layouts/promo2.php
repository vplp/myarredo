<?php

use yii\helpers\{
    Html, Url
};

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= substr(Yii::$app->language, 0, 2) ?>">
<head>
    <base href="<?= Yii::$app->getRequest()->hostInfo . Url::toRoute(['/']) ?>">
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= $this->title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="/promo1/img/myarredo_favicon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="/promo1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/promo1/css/main.css">

    <?php $this->head(); ?>
</head>
<body<?= DOMAIN_TYPE == 'ru' ? ' class="rulang"' : '' ?> data-langval="<?=DOMAIN_TYPE == 'com' ? 'it' : DOMAIN_TYPE?>">
<?php $this->beginBody() ?>
<div class="wrapperbox">

<?= $content ?>

<?= $this->render('parts/_footer_promo2', []) ?>

<?= $this->render('parts/_jivosite', []) ?>

<?= $this->render('parts/_yandex_metrika', []) ?>

<?= $this->render('parts/_google_metrika', []) ?>

<?= $this->render('parts/_cookie', []) ?>

<input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">
<!-- font awesome -->
<link rel="stylesheet" href="/promo1/font-awesome/css/font-awesome.min.css">
<!-- jQuery Library -->
<script src="/promo1/js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap js -->
<script src="/promo1/js/bootstrap.bundle.min.js"></script>
<!-- jQuery validate form + language ru it -->
<script src="/promo1/plugins/jquery-validate/jquery.validate.min.js"></script>
<!-- main js -->
<script src="/promo1/js/main.js"></script>
</div>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
