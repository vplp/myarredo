<?php

use yii\helpers\{
    Html, Url
};

?>
<!-- footer start -->
<footer class="footer">
    <div class="footerbox">
        <div class="footer-emailbox">
            <a href="mailto:myarredo@myarredo.ru" title="Оффициальный e-mail компании - Myarredo">myarredo@myarredo.ru</a>
        </div>
        <div class="footer-logobox">
            <a class="footer-logo-link" href="#header" title="Myarredo Family">
                <img src="/promo1/img/logo.svg" alt="logo">
            </a>
        </div>
        <div class="footer-phonebox">
            <a href="tel:<?= preg_replace(['/\(/','/\)/','/ /','/-/'], '', Yii::t('Promo', '+7 (968) 353 36 36')) ?>" class="phone-link"><?= Yii::t('Promo', '+7 (968) 353 36 36') ?></a>
        </div>
    </div>
</footer>
<!-- footer end -->