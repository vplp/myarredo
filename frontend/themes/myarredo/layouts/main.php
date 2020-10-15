<?php

use yii\helpers\{
    Html, Url
};
use frontend\widgets\Alert;
use frontend\modules\banner\widgets\BackgroundBanner;
use frontend\themes\myarredo\assets\AppAsset;
// use frontend\themes\myarredo\assets\FontsAsset;

// FontsAsset::register($this);
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
    <link rel="shortcut icon" href="/myarredo-ico.svg" type="image/x-icon" />

    <!-- preloader styles -->
    <style>
        .preloader-container {
            position: fixed;
            width: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            /* background-image: linear-gradient(#448339, #45b431); */
            /* background-color: #F3F2F0; */
            background-color: rgba(243, 242, 240, 0.98);
            z-index: 9999;
        }

        .preloaderbox {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            animation-delay: 1s;
        }

        .item-1 {
            width: 20px;
            height: 20px;
            background: #f583a1;
            border-radius: 50%;
            background-color: #eed968;
            margin: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes scale {
            0% {
                transform: scale(1);
            }
            50%,
            75% {
                transform: scale(2.5);
            }
            78%, 100% {
                opacity: 0;
            }
        }

        .item-1:before {
            content: '';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #eed968;
            opacity: 0.7;
            animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
            animation-delay: 200ms;
            transition: 0.5s all ease;
            transform: scale(1);
        }

        .item-2 {
            width: 20px;
            height: 20px;
            background: #f583a1;
            border-radius: 50%;
            background-color: #eece68;
            margin: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes scale {
            0% {
                transform: scale(1);
            }
            50%,
            75% {
                transform: scale(2.5);
            }
            78%, 100% {
                opacity: 0;
            }
        }

        .item-2:before {
            content: '';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #eece68;
            opacity: 0.7;
            animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
            animation-delay: 400ms;
            transition: 0.5s all ease;
            transform: scale(1);
        }

        .item-3 {
            width: 20px;
            height: 20px;
            background: #f583a1;
            border-radius: 50%;
            background-color: #eec368;
            margin: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes scale {
            0% {
                transform: scale(1);
            }
            50%,
            75% {
                transform: scale(2.5);
            }
            78%, 100% {
                opacity: 0;
            }
        }

        .item-3:before {
            content: '';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #eec368;
            opacity: 0.7;
            animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
            animation-delay: 600ms;
            transition: 0.5s all ease;
            transform: scale(1);
        }

        .item-4 {
            width: 20px;
            height: 20px;
            background: #f583a1;
            border-radius: 50%;
            background-color: #eead68;
            margin: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes scale {
            0% {
                transform: scale(1);
            }
            50%,
            75% {
                transform: scale(2.5);
            }
            78%, 100% {
                opacity: 0;
            }
        }

        .item-4:before {
            content: '';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #eead68;
            opacity: 0.7;
            animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
            animation-delay: 800ms;
            transition: 0.5s all ease;
            transform: scale(1);
        }

        .item-5 {
            width: 20px;
            height: 20px;
            background: #f583a1;
            border-radius: 50%;
            background-color: #ee8c68;
            margin: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes scale {
            0% {
                transform: scale(1);
            }
            50%,
            75% {
                transform: scale(2.5);
            }
            78%, 100% {
                opacity: 0;
            }
        }

        .item-5:before {
            content: '';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #ee8c68;
            opacity: 0.7;
            animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
            animation-delay: 1000ms;
            transition: 0.5s all ease;
            transform: scale(1);
        }
    </style>
    <!-- end preloader styles -->

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

<?= BackgroundBanner::widget([
    'city_id' => Yii::$app->city->getCityId()
]); ?>

<?= $content ?>

<?= $this->render('parts/_footer', []) ?>

<?= $this->render('parts/_jivosite', []) ?>

<?= $this->render('parts/_yandex_metrika', []) ?>

<?= $this->render('parts/_google_metrika', []) ?>

<input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">
<div class="modal fade" id="ajaxFormFeedbackModal"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
