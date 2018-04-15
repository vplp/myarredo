<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\menu\widgets\menu\Menu;
use frontend\modules\location\widgets\Cities;
use frontend\modules\user\widgets\topBarInfo\topBarInfo;
use frontend\modules\user\widgets\partner\PartnerInfo;
use frontend\modules\user\widgets\partner\PartnerMap;

$bundle = AppAsset::register($this);

?>

<div class="footer">
    <div class="container-wrap">
        <div class="contacts">
            <div class="cont-flex">
                <div class="cont-info">
                    <div class="cont-info-in">
                        <div class="cont-info-border">
                            <h4>Контакты</h4>
                            <div class="ico">
                                <img src="<?= $bundle->baseUrl ?>/img/phone.svg">
                            </div>
                            <p>Получить консультацию в Москве</p>
                            <p class="num">+7 (495) 150-21-21</p>
                            <div class="ico">
                                <img src="<?= $bundle->baseUrl ?>/img/marker-map.png">
                            </div>
                            <p>Студия Триумф</p>
                            <p>улица Удальцова, 1А</p>
                        </div>
                    </div>
                </div>
                <div class="cont-bg"
                     style="background-image: url(<?= $bundle->baseUrl ?>/img/cont-photo-bg.jpg);"></div>
            </div>
            <div class="white-stripe">
                <div class="icon">
                    <img src="<?= $bundle->baseUrl ?>/img/markers.svg" alt="">
                </div>
                <a href="#">Другие офисы продаж в Москве</a>
            </div>
        </div>

        <?= PartnerMap::widget(['city' => Yii::$app->city->getCity()]) ?>

        <?= Cities::widget() ?>


        <div class="bot-footer">
            <div class="container large-container">
                <div class="footer-cont">
                    <div class="logo-reg">
                        <a href="/" class="logo">
                            <img src="<?= $bundle->baseUrl ?>/img/logo.svg" alt="">
                        </a>
                        <?= topBarInfo::widget() ?>
                    </div>
                    <div class="menu-items">
                        <?= Menu::widget(['alias' => 'footer']) ?>
                    </div>
                    <div class="soc-copy">
                        <div class="social">
                            <a href="https://www.facebook.com/Myarredo/" target="_blank" rel="nofollow">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="https://www.instagram.com/my_arredo_family/" target="_blank" rel="nofollow">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="copyright">
                            2018 (с) MyArredo, лучшая мебель из италии для вашего дома </br>
                            Программирование сайта - <a href="#">VipDesign</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container large-container">
        <div class="row">

            <div class="col-md-4 center">

                <?= Menu::widget(['alias' => 'footer']) ?>

            </div>

            <div class="col-md-4 center" itemscope itemtype="http://schema.org/Organization">

                <?= PartnerInfo::widget() ?>

                <?= Html::a(
                    Yii::t('app', 'View all sales offices'),
                    Url::toRoute('/page/contacts/list-partners'),
                    ['class' => 'more']
                ); ?>

                <div class="social">
                    <a href="https://www.facebook.com/Myarredo/" target="_blank" rel="nofollow">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.instagram.com/my_arredo_family/" target="_blank" rel="nofollow">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                </div>

            </div>

            <div class="col-md-4 center">

                <?= topBarInfo::widget() ?>

                <div class="copy">
                    <div class="copy-slogan">
                        2015 - <?= date('Y'); ?> (с) <?= Yii::t('app','MyArredo, лучшая мебель из италии для вашего дома') ?>
                    </div>
                    <div class="fund"><?= Yii::t('app','Программирование сайта') ?>' - <a href="http://www.vipdesign.com.ua/" rel="nofollow">VipDesign</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?= Cities::widget() ?>

</footer>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog"></div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-54015829-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-54015829-1');
</script>

<script type="text/javascript">
    var __cs = __cs || [];
    __cs.push(["setCsAccount", "KNKIlw22peShQSsYcaBCDumFwgrDNrWx"]);
</script>
<script type="text/javascript" async src="//app.comagic.ru/static/cs.min.js"></script>
