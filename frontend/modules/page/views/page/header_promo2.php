<?php

use yii\helpers\{
    Html, Url
};

$arLangs = array(
    'ru'=>array(
        'img'=>'ruslang.jpg',
        'lang'=>'ru',
        'langtext'=>'Рус',
        'title'=>'Русский',
        'domen'=>'.ru',
        'langs'=>'ru-RU'
    ),
    'en'=>array(
        'img'=>'englang.png',
        'lang'=>'en',
        'langtext'=>'Eng',
        'title'=>'English',
        'domen'=>'.uk',
        'langs'=>'en-EN'
    ),
    'it'=>array(
        'img'=>'itlang.jpg',
        'lang'=>'it',
        'langtext'=>'It',
        'title'=>'Italiano',
        'domen'=>'.com/it',
        'langs'=>'it-IT'
    ),
    'de'=>array(
        'img'=>'germany.png',
        'lang'=>'de',
        'langtext'=>'De',
        'title'=>'Deutschland',
        'domen'=>'.de',
        'langs'=>'de-DE'
    ),
    'fr'=>array(
        'img'=>'france.png',
        'lang'=>'fr',
        'langtext'=>'Fra',
        'title'=>'France',
        'domen'=>'.fr',
        'langs'=>'fr-FR'
    ),
    'ua'=>array(
        'img'=>'ukraine.png',
        'lang'=>'ua',
        'langtext'=>'Ukr',
        'title'=>'Україна',
        'domen'=>'.ua',
        'langs'=>'uk-UA'
    ),
);

$domain = DOMAIN_TYPE == 'com' ? 'it' : (DOMAIN_TYPE == 'uk' ? 'en' : DOMAIN_TYPE);

?>

<!-- header -->
<header id="header" class="header">
    <!-- box -->
    <div class="headerbox">

        <!-- language -->
        <div class="header-langbox">
            <!-- switch -->
            <div class="langswitch" title="<?= Yii::t('Promo', 'Изменить язык сайта') ?>">
                <div class="flag">
                    <img src="/promo1/img/<?=$arLangs[$domain]['img']?>" alt="lang <?=$arLangs[$domain]['lang']?>">
                </div>
                <div class="langtext"><?=$arLangs[$domain]['langtext']?></div>
                <div class="arrow">
                    <img src="/promo1/img/down-arrow.svg" alt="arrow">
                </div>
            </div>
            <!-- end switch -->
            <!-- drop -->
            <div class="langdropbox">
                <div class="langdrop">
                    <?php foreach ($langs as $lang) {
                        $shortLang = explode('-', $lang['lang'])[0];
                        if ($lang['lang'] == $arLangs[$domain]['langs']) continue;?>
                        <a <?=$shortLang?> href="https://myarredo<?=$arLangs[$shortLang]['domen']?>/promo2/" class="langdrop-item" title="<?=$arLangs[$shortLang]['title']?>">
                            <div class="flag">
                                <img src="/promo1/img/<?=$arLangs[$shortLang]['img']?>" alt="lang <?=$arLangs[$shortLang]['lang']?>">
                            </div>
                            <div class="langtext"><?=$arLangs[$shortLang]['langtext']?></div>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <!-- end drop -->
        </div>
        <!-- end language -->

        <!-- logo -->
        <div class="header-logobox" title="Myarredo Family">
            <img src="/promo1/img/logo.svg" alt="logo">
        </div>
        <!-- end logo -->

        <!-- phones -->
        <div class="header-phonebox">
            <span class="for-phone"><?= Yii::t('Promo', 'звоните прямо сейчас 8:00-22:00') ?></span>
            <a href="tel:<?= preg_replace(['/\(/','/\)/','/ /','/-/'], '', Yii::t('Promo', '+7 (968) 353 36 36')) ?>" class="phone-link"><?= Yii::t('Promo', '+7 (968) 353 36 36') ?></a>
        </div>
        <!-- end phones -->

    </div>
    <!-- end box -->
</header>
<!-- end header -->