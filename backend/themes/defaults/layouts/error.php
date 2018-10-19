<?php

use backend\widgets\Alert;
use backend\themes\defaults\assets\AppAsset;

$bundle = AppAsset::register($this);

$this->beginPage();

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
    <input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">
</head>
<body class="gray-bg">

<?php $this->beginBody() ?>

<?= Alert::widget(); ?>

<div class="middle-box text-center animated fadeInDown">

    <?= $content ?>

</div>

<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>
