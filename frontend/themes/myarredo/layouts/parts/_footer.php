<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\menu\widgets\menu\Menu;
use frontend\modules\location\widgets\Cities;
use frontend\modules\user\widgets\topBarInfo\topBarInfo;
use frontend\modules\user\widgets\partner\PartnerInfo;

?>

    <footer>
        <div class="container large-container">
            <div class="row">

                <div class="col-md-4 center">

                    <?= Menu::widget(['alias' => 'footer']) ?>

                </div>

                <div class="col-md-4 center" itemscope itemtype="http://schema.org/Organization">

                    <?= PartnerInfo::widget() ?>

                    <?= Html::a(
                        'Посмотреть все офисы продаж',
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
                            2015 - <?= date('Y'); ?> (с) MyArredo, лучшая мебель из италии для вашего дома
                        </div>
                        <div class="fund">Программирование сайта - <a href="http://www.vipdesign.com.ua/" rel="nofollow">VipDesign</a></div>
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

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function () {
                try {
                    w.yaCounter24814823 = new Ya.Metrika({
                        id: 24814823,
                        clickmap: true,
                        trackLinks: true,
                        accurateTrackBounce: true,
                        webvisor: true,
                        trackHash: true
                    });
                } catch (e) {
                }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/24814823" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

<?php if (Yii::$app->getUser()->isGuest && Yii::$app->city->domain == 'ru'): ?>

    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type='text/javascript'>
        (function () {
            var widget_id = '8vo3Plg4NB';
            var d = document;
            var w = window;

            function l() {
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = '//code.jivosite.com/script/geo-widget/' + widget_id;
                var ss = document.getElementsByTagName('script')[0];
                ss.parentNode.insertBefore(s, ss);
            }

            if (d.readyState == 'complete') {
                l();
            } else {
                if (w.attachEvent) {
                    w.attachEvent('onload', l);
                } else {
                    w.addEventListener('load', l, false);
                }
            }
        })();</script>
    <!-- {/literal} END JIVOSITE CODE -->

<?php endif; ?>

<style>
    .jivo-btn {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        margin: 0;
        text-transform: none;
        cursor: pointer;
        background-image: none;
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: normal;
        line-height: 1.428571429;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        border: 0px;
        border-radius: 4px;
        white-space: nowrap;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -o-user-select: none;
        user-select: none;
    }
    .jivo-btn:hover {
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 2px rgba(0,0,0,0.2), inset 0 0 20px 10px rgba(255,255,255,0.3);
        -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 2px rgba(0,0,0,0.2), inset 0 0 20px 10px rgba(255,255,255,0.3);
        -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 2px rgba(0,0,0,0.2), inset 0 0 20px 10px rgba(255,255,255,0.3);
    }
    .jivo-btn.jivo-btn-light:hover{
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 2px rgba(0,0,0,0.3), inset 0 0 20px 10px rgba(255,255,255,0.1);
        -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 2px rgba(0,0,0,0.3), inset 0 0 20px 10px rgba(255,255,255,0.1);
        -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 2px rgba(0,0,0,0.3), inset 0 0 20px 10px rgba(255,255,255,0.1);
    }
    .jivo-btn.jivo-btn-light{
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 1px rgba(0,0,0,0.3);
        -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 1px rgba(0,0,0,0.3);
        -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 1px 1px rgba(0,0,0,0.3);
    }
    .jivo-btn:active,
    .jivo-btn.jivo-btn-light:active{
        box-shadow: 0 1px 0px rgba(255,255,255,0.4), inset 0 0 15px rgba(0,0,0,0.2);
        -moz-box-shadow: 0 1px 0px rgba(255,255,255,0.4), inset 0 0 15px rgba(0,0,0,0.2);
        -webkit-box-shadow: 0 1px 0px rgba(255,255,255,0.4), inset 0 0 15px rgba(0,0,0,0.2);
        cursor: pointer;
    }
    .jivo-btn:active {
        outline: 0;
        background-image: none;
        -webkit-box-shadow: inset 0 3px 5px rgba(0,0,0,0.125);
        box-shadow: inset 0 3px 5px rgba(0,0,0,0.125);
    }
    .jivo-btn-gradient {
        background-image: url(//static.jivosite.com/button/white_grad_light.png);
        background-repeat: repeat-x;
    }
    .jivo-btn-light.jivo-btn-gradient {
        background-image: url(//static.jivosite.com/button/white_grad.png);
    }
    .jivo-btn-icon {
        width:17px;
        height: 20px;
        background-repeat: no-repeat;
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        margin-left: -5px;
    }
    .jivo-btn-light {
        color: #fff;
    }
    ..jivo-btn-dark {
        color: #222;
    }
</style>
<!--[if lte IE 7]>
<style type="text/css">
    .jivo-btn, .jivo-btn-icon  {
        display: inline;
    }
</style>
<![endif]-->
<div class="jivo-btn jivo-online-btn jivo-btn-light" onclick="jivo_api.open();" style="font-family: Tahoma, Arial;font-size: 14px;background-color: #d63228;border-radius: 30px;-moz-border-radius: 30px;-webkit-border-radius: 30px;height: 24px;line-height: 24px;padding: 0 12px 0 12px;font-weight: normal;font-style: normal"><div class="jivo-btn-icon" style="background-image: url(//static.jivosite.com/button/chat_light.png);"></div>Напишите нам, мы в онлайне!</div><div class="jivo-btn jivo-offline-btn jivo-btn-light" onclick="jivo_api.open();" style="font-family: Tahoma, Arial;font-size: 14px;background-color: #d63228;border-radius: 30px;-moz-border-radius: 30px;-webkit-border-radius: 30px;height: 24px;line-height: 24px;padding: 0 12px 0 12px;display: none;font-weight: normal;font-style: normal"><div class="jivo-btn-icon" style="background-image: url(//static.jivosite.com/button/mail_light.png);"></div>Оставьте сообщение!</div>
