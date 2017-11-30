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
                    <div class="fund">Программирование сайта - <a href="http://www.vipdesign.com.ua/">VipDesign</a></div>
                </div>
            </div>

        </div>
    </div>

    <?= Cities::widget() ?>

</footer>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-54015829-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-54015829-1');
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter24814823 = new Ya.Metrika({
                    id:24814823,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/24814823" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->