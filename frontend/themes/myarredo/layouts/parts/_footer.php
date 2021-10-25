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
$url = Url::to(['/forms/forms/ajax-get-form-feedback'], true);

?>
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400;0,500;0,700;0,800;1,400&display=swap"
      rel="stylesheet">
<div class="footer jsftr" data-url="<?= $url; ?>">
    <div class="container-wrap">

        <?php if (!in_array(DOMAIN_TYPE, ['com', 'de', 'fr', 'uk', 'kz', 'co.il']) && !in_array(Yii::$app->controller->id, ['sale'])) { ?>
            <div class="contacts">
                <div class="cont-flex">
                    <?php if (!in_array(Yii::$app->controller->id, ['sale-italy'])) {
                        echo PartnerInfo::widget();
                    } else {
                        if ($this->beginCache('FormFeedbackSaleItaly' . Yii::$app->city->getCityId() . Yii::$app->language, ['duration' => 7200])) {
                            echo FormFeedback::widget(['view' => 'form_feedback_sale_italy']);
                            $this->endCache();
                        }
                    } ?>
                </div>

                <?php
                if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
                } else { ?>
                    <div class="white-stripe">
                        <div class="icon">
                            <img width="45" height="30" src="<?= $bundle->baseUrl ?>/img/markers.svg" alt="">
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
        } else if (!in_array(DOMAIN_TYPE, ['com', 'de', 'fr', 'uk', 'kz', 'co.il'])) {
            if ($this->beginCache('CitiesWidget' . Yii::$app->city->getCityId() . Yii::$app->language, ['duration' => 7200])) {
                echo Cities::widget();
                $this->endCache();
            }
        } ?>

        <div class="footer-navpanel">
            <div class="bot-list">
                <?php if (DOMAIN_NAME == 'myarredo' && Yii::$app->controller->action->id != 'error' &&
                    in_array(DOMAIN_TYPE, ['ru', 'by', 'ua', 'com', 'de', 'fr', 'uk', 'co.il']) &&
                    !in_array(Yii::$app->controller->id, ['articles', 'contacts', 'sale', 'countries-furniture']) &&
                    !in_array(Yii::$app->controller->module->id, ['news'])
                ) { ?>
                    <div class="one-list-cont lang-cont">
                        <?= LangSwitch::widget(['view' => 'lang_switch_mobile', 'noIndex' => $this->context->noIndex]) ?>
                    </div>
                <?php } ?>

                <?php if (in_array(DOMAIN_TYPE, ['ru']) && Yii::$app->controller->action->id != 'error') { ?>
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

                        <?= Html::a(
                            Html::img($bundle->baseUrl . '/img/logo.svg', ['width' => '233', 'height' => '33', 'loading' => 'lazy', 'alt' => 'Myarredo']),
                            Yii::$app->controller->id != 'home' ? Url::toRoute('/home/home/index') : null,
                            ['class' => 'logo']
                        ) ?>

                        <?= topBarInfo::widget(); ?>

                    </div>

                    <?php if ($this->beginCache('Footer' . Yii::$app->city->getCityId() . Yii::$app->language, ['duration' => 7200])) { ?>
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
                            } elseif (!in_array(DOMAIN_TYPE, ['com', 'de', 'fr', 'uk', 'kz', 'co.il'])) {
                                echo Menu::widget(['alias' => 'footer']);
                            } elseif (in_array(DOMAIN_TYPE, ['com', 'de', 'fr', 'uk', 'kz', 'co.il'])) {
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

                                <?php if (in_array(DOMAIN_TYPE, ['by', 'ru', 'ua'])) { ?>
                                    <?= Yii::t('app', 'Программирование сайта') ?> -
                                    <a href="http://www.vipdesign.com.ua/" rel="nofollow">VipDesign</a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        $this->endCache();
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="totopbox">
        <a href="#top">
            <img src="/" data-src="<?= $bundle->baseUrl ?>/img/totop.jpg" alt="top" class="totop-img lazy">
        </a>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog"></div>
<div class="modal fade" id="ajaxFormFeedbackModal"></div>

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
