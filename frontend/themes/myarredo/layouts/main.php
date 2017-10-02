<?php

use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\menu\widgets\menu\Menu;
use frontend\themes\myarredo\widgets\Alert;
use frontend\modules\location\widgets\Cities;

$bundle = AppAsset::register($this);
$session = Yii::$app->session;

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

    <footer>
        <div class="container large-container">
            <div class="row">
                <div class="col-md-4 center">

                    <?= Menu::widget(['alias' => 'footer']) ?>

                </div>
                <div class="col-md-4 center">
                    <div class="cons">Получить консультацию в <?= $session['city']['lang']['title_where'] ?></div>
                    <div class="tel"><i class="fa fa-phone" aria-hidden="true"></i>+7 (499) 705-89-98</div>
                    <div class="stud">
                        Студия "СТАРЫЙ РИМ"</br>
                        Малый Харитоньевский переулок, 7с1
                    </div>
                    <a href="#" class="more">Посмотреть все офисы продаж</a>
                    <div class="social">
                        <a href="#">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 center">

                    <?= \frontend\modules\user\widgets\topBarInfo\topBarInfo::widget() ?>

                    <div class="copy">
                        <div class="copy-slogan">
                            2015 - <?= date('Y'); ?> (с) MyArredo, лучшая мебель из италии для вашего дома
                        </div>
                        <div class="fund">Программирование сайта - <a href="http://www.vipdesign.com.ua/">VipDesign</a></div>
                    </div>
                </div>
            </div>
        </div>

        <?= Cities::widget() ?>

    </footer>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>