<?php

use yii\helpers\{
    Html, Url
};
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\menu\widgets\menu\Menu;
use frontend\modules\location\widgets\Cities;
use frontend\modules\user\widgets\topBarInfo\topBarInfo;
use frontend\modules\user\widgets\partner\PartnerInfo;
use frontend\modules\forms\widgets\FormFeedback;
use frontend\modules\sys\widgets\lang\LangSwitch;
use frontend\modules\location\widgets\ChangeCurrency;

$bundle = AppAsset::register($this);

?>

<div class="footer">
    <div class="container-wrap">

        <?php if (DOMAIN_TYPE != 'com' && !in_array(Yii::$app->controller->id, ['sale'])) { ?>
            <div class="contacts">
                <div class="cont-flex">
                    <?php if (!in_array(Yii::$app->controller->id, ['sale-italy'])) {
                        echo PartnerInfo::widget();
                    } else {
                        echo FormFeedback::widget(['view' => 'form_feedback_sale_italy']);
                    } ?>
                </div>

                <?php
                if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
                } else { ?>
                    <div class="white-stripe">
                        <div class="icon">
                            <img src="<?= $bundle->baseUrl ?>/img/markers.svg" alt="">
                        </div>

                        <?= Html::a(
                            Yii::t('app', 'View all sales offices'),
                            Url::toRoute('/page/contacts/list-partners')
                        ); ?>
                    </div>
                <?php } ?>

            </div>

        <?php } ?>

        <?php
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
        } else if (!in_array(DOMAIN_TYPE, ['com', 'de'])) {
            echo Cities::widget();
        } ?>

        <div class="footer-navpanel">
            <div class="bot-list">
                <?php if (DOMAIN_NAME != 'myarredofamily') { ?>
                    <div class="one-list-cont lang-cont">
                        <?= LangSwitch::widget(['view' => 'lang_switch_mobile']) ?>
                    </div>
                <?php } ?>

                <?php if (in_array(DOMAIN_TYPE, ['ru'])) { ?>
                    <div class="one-list-cont curency-cont">
                        <?= ChangeCurrency::widget(['view' => 'change_currency_mobile']) ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="bot-footer">
            <div class="container large-container">
                <div class="footer-cont">
                    <div class="logo-reg">
                        <a href="/" class="logo">
                            <img src="<?= $bundle->baseUrl ?>/img/logo.svg" alt="">
                        </a>

                        <?= topBarInfo::widget(); ?>

                    </div>

                    <ul class="nav ftr-nav">
                        <li><?= FormFeedback::widget(['view' => 'ajax_form_feedback']); ?></li>
                        <?php if (in_array(Yii::$app->language, ['ru-RU', 'uk-UA'])) { ?>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Стать главным партнером в городе') . '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                                    'https://www.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . '/uploads/myarredofamily-for-partners.pdf',
                                    ['class' => 'btn btn-gopartner click-on-become-partner', 'target' => '_blank']
                                ); ?>
                            </li>
                        <?php } ?>
                    </ul>

                    <div class="menu-items">

                        <?php
                        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
                            echo '';
                        } elseif (!in_array(DOMAIN_TYPE, ['com', 'de'])) {
                            echo Menu::widget(['alias' => 'footer']);
                        } elseif (in_array(DOMAIN_TYPE, ['com', 'de'])) {
                            echo Menu::widget(['alias' => 'footer-com']);
                        } ?>

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

                            <?php if (DOMAIN_TYPE == 'by') { ?>
                                2013 - <?= date('Y'); ?> (с)
                                <?= str_replace(['#городе#', '#nella citta#'], Yii::$app->city->getCityTitleWhere(), Yii::$app->param->getByName('FOOTER_COPYRIGHT_BY')); ?>
                                <br>
                            <?php } elseif (DOMAIN_TYPE == 'ua') { ?>
                                2013 - <?= date('Y'); ?> (с)
                                <?= str_replace(['#городе#', '#nella citta#'], Yii::$app->city->getCityTitleWhere(), Yii::$app->param->getByName('FOOTER_COPYRIGHT_UA')); ?>
                                <br>
                            <?php } else { ?>
                                2013 - <?= date('Y'); ?> (с)
                                <?= str_replace(['#городе#', '#nella citta#'], Yii::$app->city->getCityTitleWhere(), Yii::$app->param->getByName('FOOTER_COPYRIGHT_RU')); ?>
                                <br>
                            <?php } ?>

                            <?= Yii::t('app', 'Программирование сайта') ?> -
                            <a href="http://www.vipdesign.com.ua/" rel="nofollow">VipDesign</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="totopbox">
        <a href="#top">
            <img src="<?= $bundle->baseUrl ?>/img/totop.jpg" alt="top" class="totop-img">
        </a>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog"></div>

<?php if (DOMAIN_TYPE == 'ru' && Yii::$app->getUser()->isGuest) { ?>
    <script>
        var __cs = __cs || [];
        __cs.push(["setCsAccount", "UmbSor8qhGbovgqKXcAqTSVMMinwFmSy"]);
    </script>
    <script async src="https://app.uiscom.ru/static/cs.min.js"></script>
<?php } ?>

<?php if (!in_array(Yii::$app->city->getCityId(), [5])) { ?>
    <script src="//code.jivosite.com/widget/yG6Q733QpB" async></script>
<?php } ?>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "https://www.<?= DOMAIN_NAME . '.' . DOMAIN_TYPE ?>",
    "name": "MyArredoFamily",
    "email": "info@myarredo.ru",
    "logo": "<?= 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE ?>/uploads/myarredo-ico.jpg",
    "sameAs": [
        "https://www.facebook.com/Myarredo/",
        "https://www.instagram.com/my_arredo_family/"
    ]
}

</script>
