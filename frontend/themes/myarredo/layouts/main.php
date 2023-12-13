<?php

use yii\helpers\{
    Html, Url
};
use frontend\widgets\Popup;
use frontend\modules\banner\widgets\BackgroundBanner;
use frontend\themes\myarredo\assets\{
    AppAsset, FirstAsset
};

FirstAsset::register($this);

$bundle = AppAsset::register($this); ?>
<?php \defyma\helper\Minifier::begin(); ?>
<?php $this->beginPage();?>
<!DOCTYPE html>
<html lang="<?= substr(Yii::$app->language, 0, 2) ?>">
<head>
    <base href="<?= Yii::$app->getRequest()->hostInfo . Url::toRoute(['/']) ?>">
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= $this->title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noyaca"/>
    <meta name="p:domain_verify" content="98b95b6411b60192d93d0bff2679df8d"/>

    <link rel="dns-prefetch" href="https://www.google.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://mc.yandex.ru">
    <link rel="dns-prefetch" href="https://img.<?= DOMAIN_NAME . '.' . DOMAIN_TYPE ?>">
    <link rel="dns-prefetch" href="https://www.gstatic.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">

    <link rel="icon" href="https://img.<?= DOMAIN_NAME . '.' . DOMAIN_TYPE ?>/myarredo-ico.svg" type="image/svg+xml"/>
    <link rel="icon" href="https://img.<?= DOMAIN_NAME . '.' . DOMAIN_TYPE ?>/favicon.ico" type="image/x-icon"/>

    <link rel="preload" href="/css/font-awesome/fonts/fontawesome-webfont.woff2?v=4.7.0" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="/css/font-open-sans/open-sans.woff2?v=1.0.0" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="/css/font-open-sans/open-sans1.woff2?v=1.0.0" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="/css/font-open-sans/open-sans2.woff2?v=1.0.0" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="/css/bootstrap/dist/fonts/glyphicons-halflings-regular.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="https://img.myarredo.ru/uploads/thumb/1280/10aa/c33e/de37/6215/82fa/6db0/652567e6efc38-460x200.jpg" as="image" crossorigin="anonymous">

    <!-- preloader styles -->
    <style>
        @font-face{font-family:'Open Sans';font-style:normal;font-weight:300;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans.woff2?v=1.0.0) format('woff2');unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans.woff2?v=1.0.0) format('woff2');unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans.woff2?v=1.0.0) format('woff2');unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans.woff2?v=1.0.0) format('woff2');unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116}@font-face{font-family:'Open Sans';font-style:normal;font-weight:300;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans1.woff2?v=1.0.0) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans1.woff2?v=1.0.0) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans1.woff2?v=1.0.0) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans1.woff2?v=1.0.0) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}@font-face{font-family:'Open Sans';font-style:normal;font-weight:300;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans2.woff2?v=1.0.0) format('woff2');unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:400;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans2.woff2?v=1.0.0) format('woff2');unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:600;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans2.woff2?v=1.0.0) format('woff2');unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Open Sans';font-style:normal;font-weight:700;font-stretch:100%;font-display:swap;src:url(/css/font-open-sans/open-sans2.woff2?v=1.0.0) format('woff2');unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF}
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
        body{font-family:'Open Sans',cursive,sans-serif!important}.container-wrap{max-width:1600px;margin:0 auto}.form-control{border-color:transparent;background-color:#f3f2f0}.form-control:focus{border-color:#bdbcb3;-webkit-box-shadow:none;box-shadow:none}.container{width:100%!important}h1{font-family:Vollkorn,sans-serif!important;font-weight:500;font-size:35px}.header,.header .lang-selector .lang-drop-down a:hover,.home-main{background:#f3f2f0}.header .container-wrap,.home-main .container-wrap{background:#fff}.header .top-header{border-bottom:1px solid #bdbcb3;height:46px;width:100%}.header .top-header .container{height:100%;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;position:relative}.header .bot-header .container:after,.header .bot-header .container:before,.header .bot-header .navigation .list-level a:before,.header .top-header .container:after,.header .top-header .container:before,.mobile-menu .navigation li .list-level-wrap,.mobmenu-wishlistbox .my-notebook.wishlist .inscription .for-nt-arr,.mobmenu-wishlistbox .my-notebook.wishlist .inscription .for-nt-text{display:none}.header .top-header .left-part{display:-webkit-box;display:-ms-flexbox;display:flex}.header .top-header .left-part .logo{padding-top:6px}.header .top-header .right-part{display:-webkit-box;display:-ms-flexbox;display:flex;height:100%}/*.header .bot-header .navigation .list-level li:nth-child(3n+3),*/.header .top-header .right-part .navbar-right{margin-right:0}.header .top-header a{font-family:"Open Sans",cursive,sans-serif;color:#535351}.header .bot-header .navigation a:active,.header .bot-header .navigation a:focus,.header .bot-header .navigation a:hover,.header .top-header a:active,.header .top-header a:focus,.header .top-header a:hover,.mob-fabrics-link:focus,.mob-fabrics-link:hover{text-decoration:none}.header .top-header .phone{font-size:17px;font-weight:600}.header .top-header .descr,.mobile-header .after-num{font-size:9px;color:#c4242e;text-transform:uppercase;font-weight:600}.header .search-cont form,.header .top-header .container .row{width:100%}.header .top-header .my-notebook{cursor:pointer}.header .top-header .my-notebook.dropdown{margin-top:10px}.header .top-header .notebook-but{background:#448339;font-size:13px;color:#fff;text-transform:uppercase;font-weight:500;padding:5px 10px;border-radius:2px;-webkit-box-shadow:0 0 3px 0 rgba(0,0,0,.25);box-shadow:0 0 3px 0 rgba(0,0,0,.25);white-space:nowrap}.header .top-header .notebook-but .fa{margin-right:3px}.header .phone-num{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding-right:2px;padding-left:6px;border-right:none}.header .phone-num .descr,.header .phone-num .phone,.mob-fabrics-link .for-mobmenu-fabicon,.mobile-header.open+.mobile-openbg,.mobmenu-panel .for-mobmenu-barsicon{display:block}.header .back-call,.header .select-city{display:-webkit-box;display:-ms-flexbox;border-right:1px solid #bdbcb3;display:flex;-webkit-box-align:center;font-size:14px}.header .phone-num .fa{color:#bdbcb3;font-size:18px;margin-right:8px}.header .back-call{-ms-flex-align:center;align-items:center;padding:0 20px 0 17px}.header .back-call .fa{margin-right:2px;font-size:20px;color:#bdbcb3;position:relative;top:2px}.header .select-city{-ms-flex-align:center;align-items:center;cursor:pointer;padding:0}.header .select-city .js-select-city,.header .wishlist{display:-ms-flexbox;-webkit-box-align:center;height:100%}.header .select-city .js-select-city{display:-webkit-box;display:flex;width:100%;padding:0 20px 0 17px;-ms-flex-align:center;align-items:center}.header .select-city .js-select-city.opened{border-bottom:1px solid #fff;margin-bottom:-2px}.header .select-city .fa{font-size:20px;color:#bdbcb3;margin-right:6px}.header .select-city .city-list-cont{left:0;right:0;top:calc(100% + 1px);position:absolute;background:#fff;z-index:20;display:none}.header .select-city .links-cont{list-style:none;width:100%;-webkit-column-count:5;-moz-column-count:5;column-count:5;padding:30px 0 30px 90px;line-height:36px}.header .select-city .links-cont a{color:#535351;position:relative;padding-left:30px}.header .select-city .links-cont a:before{content:"";position:absolute;width:18px;height:18px;top:50%;left:0;-webkit-transform:translateY(-50%);transform:translateY(-50%);border-radius:9px;background-color:#e6e4e1}.header .select-city .links-cont .active a:before{background-color:#448339}.header .wishlist{position:relative;background-color:transparent;color:#bdbcb3!important;padding:0 12px 0 5px;display:-webkit-box;display:flex;-ms-flex-align:center;align-items:center;text-transform:uppercase;font-size:13px;font-weight:500}.header .bot-header .container,.header .sign-in{display:-webkit-box;display:-ms-flexbox;height:100%}.header .wishlist .fa{font-size:22px;margin-right:4px}.header .wishlist .inscription{position:absolute;top:14px;left:13px;color:#fff;font-size:10px}.header .sign-in{display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:0 0 0 16px;font-size:14px}.header .sign-in.withicon{padding:0 14px 0 16px}.header .sign-in.withicon::before{content:'';display:inline-block;width:35px;height:33px;overflow:hidden;background-image:url(../img/shop_profile.jpg);background-repeat:no-repeat;background-position:center center;background-size:contain;margin-right:5px}.header .sign-in .fa{margin-right:5px;color:#bdbcb3;font-size:20px;position:relative;top:2px}.header .sign-in .fa.fa-user-o{margin-top:-3px}.header .bot-header{height:52px;border-bottom:1px solid #bdbcb3}.header .bot-header .container{display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;position:relative}.header .bot-header .navigation{list-style:none;display:-webkit-box;display:-ms-flexbox;display:flex;padding-left:0;margin:0}.header .bot-header .navigation a{font-size:15px;text-transform:uppercase;color:#41403e;padding:10px;font-weight:600}.header .bot-header .navigation li:first-child a{padding-left:0}.header .bot-header .navigation .has-list>a{color:#c4242e;position:relative}.header .bot-header .navigation .has-list>a:before{content:"\f0da";font-family:FontAwesome;font-size:14px;margin-right:4px}.header .bot-header .navigation .list-level-wrap{display:none;top:calc(100% + 1px);position:absolute;z-index:5;left:0;right:0;border-right:1px solid #bdbcb3;border-bottom:1px solid #bdbcb3;border-left:1px solid #bdbcb3}.header .bot-header .navigation .list-level{background:#fff;left:15px;right:15px;padding:40px 125px 50px;width:100%;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;list-style:none;display:-webkit-box;display:-ms-flexbox;display:flex}.header .bot-header .navigation .list-level li{height:35px;width:275px;margin-right:94px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.header .bot-header .navigation .list-level li .img-cont{height:25px;width:25px;margin-right:15px;position:relative}.header .bot-header .navigation .list-level li .img-cont img{display:block;max-height:100%;max-width:100%;width:auto;height:auto;position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.header .bot-header .navigation .list-level a{color:#535351;font-size:15px;text-transform:none;padding:0;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;line-height:14px;-webkit-transition:.3s;transition:.3s}.header .bot-header .navigation .list-level a:hover,.order_status_in_work{color:#448339}.header .bot-header .navigation .list-level .count{color:#448339;padding-left:7px}.header .bot-header .navigation .list-level:before{content:"";position:absolute;width:18px;height:14px;top:-11px;left:5%;background-image:url(../img/level-arrow.png);background-size:contain;background-repeat:no-repeat;background-position:center}.header .bot-header .navigation .second-link .list-level:before{left:15%}.header .bot-header .navigation .third-link .list-level:before{left:27%}.header .bot-header .navigation .list-level:after{content:"";position:absolute;background:0 0;width:100%;height:50px;display:block;top:-25px;left:0}.header .logo{width:233px;display:block;margin-right:10px}.header .logo img,.home-main .top-home-img img{display:block;width:100%;height:auto}.header .search-cont{min-width:290px;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1}.header .search-cont .search-group{width:290px;margin-left:auto;display:-webkit-box;display:-ms-flexbox;display:flex}.header .search-cont .search-button{background:#448339;color:#fff;border:none;height:32px;min-width:32px}.header .search-cont input{background:#f3f2f0;border:none;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;padding-left:8px}.header .lang-selector{border-right:1px solid #bdbcb3;position:relative}.header .left-part .lang-selector:first-child .js-select-lang{padding-left:1px}.header .lang-selector.opened .fa-chevron-down{-webkit-transform:perspective(600px) rotate3d(20,0,0,180deg);transform:perspective(600px) rotate3d(20,0,0,180deg);position:relative;top:2px}.header .lang-selector .js-select-lang{padding:0 18px;height:100%;width:100%;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;font-size:14px;color:#535351}.header .lang-selector .js-select-lang .fa-globe,.header .lang-selector .lang-drop-down a .fa{color:#bdbcb3;font-size:20px;margin-right:6px}.header .lang-selector .js-select-lang .fa-chevron-down{color:#45833a;font-size:13px;margin-left:5px;-webkit-transition:.2s ease-out;transition:.2s ease-out}.header .lang-selector .lang-drop-down{background:#fff;padding-left:0;width:calc(100% + 2px);position:absolute;z-index:7;top:100%;left:-1px;list-style:none;border-left:1px solid #bdbcb3;border-right:1px solid #bdbcb3;border-bottom:1px solid #bdbcb3;display:none}.header .lang-selector .lang-drop-down a{height:45px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:0 18px;background:0 0;-webkit-transition:.1s ease-out;transition:.1s ease-out}.header .company-logo{width:100px;padding:0 16px;position:relative}.header .company-logo img{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%);max-width:100%;max-height:100%;height:auto;width:auto}.fixed-header .top-header{position:fixed;background:#fff;z-index:99;top:0;left:0;width:100%;-webkit-animation:.3s slideDown;animation:.3s slideDown}@-webkit-keyframes slideDown{0%{top:-50px}100%{top:0}}@keyframes slideDown{0%{top:-50px}100%{top:0}}.mobile-header{height:auto;min-height:80px;display:none;position:relative}.mobile-header .left-info-part{width:calc(100% - 42px);padding:10px 0}.mobile-header .right-btn-part{width:42px}.mobile-header .menu-btn{background:#535351;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;color:#fff;font-size:19px;cursor:pointer}.mobile-header .search-btn{height:50%;background:#448339;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;color:#fff}.mobile-header .logo,.mobile-header .logo img{display:block;width:100%}.mobile-header .logo img{max-width:75px;height:auto}.mobile-header .mobmenu-part .menu-btn{background-color:transparent;color:#41403e;margin:0 12px 0 8px}.mobile-header .mobmenu-part .menu-btn .fa{font-size:40px;font-weight:600}.mobile-header .left-info-part.mobmenu-part{width:150px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.mobile-header .right-btn-part.mobmenu-part{width:calc(100% - 150px);display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:5px 14px 0 0}.mobile-header .mobile-menu .stripe a,.mobile-header .mobile-menu .wishlist-mobile{display:-webkit-box;display:-ms-flexbox;-webkit-box-align:center;text-decoration:none}.mobile-header.open{z-index:1000;background-color:#fff}.mobile-header .phone-container{padding-left:22px;position:relative}.mobile-header .phone-container:before{content:"\f095";font-size:20px;font-family:FontAwesome;position:absolute;left:2px;top:55%;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.mobile-header .phone-num{font-size:14px;color:#535351;text-decoration:none;font-weight:900}.mobile-header .mobile-menu{position:absolute;z-index:999999;top:61px;left:-105%;width:100%;max-width:340px;border:1px solid #bdbcb3;background:#fff;-webkit-transition:.45s;transition:.45s}.mobile-header.open .mobile-menu{left:0}.mobile-header .mobile-menu .stripe{height:40px;border-bottom:1px solid #bdbcb3;display:-webkit-box;display:-ms-flexbox;display:flex;position:relative;z-index:1}.mobile-header .mobile-menu .stripe a{color:#535351;font-size:14px;height:100%;display:flex;-ms-flex-align:center;align-items:center;padding:0 9px;border-right:1px solid #bdbcb3}.mobile-header .mobile-menu .stripe a .fa-sign-in{color:#bebdb4;font-size:18px;margin-right:3px}.mobile-header .mobile-menu .stripe a .fa-phone{color:#bebdb4;font-size:18px;margin-right:3px;position:relative;top:2px}.mobile-header .mobile-menu .stripe a:last-child{border-right:none}.mobile-header .mobile-menu .stripe .back-call{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.mobile-header .mobile-menu .stripe .close-mobile-menu{width:42px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.mobile-header .mobile-menu .stripe .close-mobile-menu .fa-ellipsis-v{color:#448339;font-size:19px}.mobile-header .mobile-menu .wishlist-mobile{background:#448339;color:#fff;height:43px;width:100%;display:flex;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;text-transform:uppercase;font-size:13px;font-weight:600}.mobile-header .mobile-menu .wishlist-mobile .fa{font-size:16px;margin-right:5px}.mobile-header .mobile-menu .menu-list{margin:0 0 30px;list-style:none;padding-left:0;padding-top:0;max-height:75vh;overflow-y:auto}.mobile-header .mobile-menu .menu-list>li{padding-left:13px}.mobile-header .mobile-menu .menu-list a{color:#41403e;font-size:18px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;height:100%;text-decoration:none}.mobile-header .mobile-menu .logo-container{display:-webkit-box;display:-ms-flexbox;display:flex;padding:10px 0 10px 15px;margin-bottom:10px}.mobile-header .mobile-menu .logo-container img{display:block;max-height:100%;max-width:100%;height:auto;width:auto}.mobile-header .one-list-cont{border-bottom:1px solid #fff}.mobile-header .one-list-cont:last-child{border-bottom:none}.footer-navpanel .one-list,.mobile-header .one-list{background:#eeece4;height:63px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:0 15px;font-size:16px;position:relative}.mobile-header .one-list .fa{margin-right:13px;color:#bdbcb3;font-size:18px}.footer-navpanel .one-list .fa-map-marker,.mobile-header .one-list .fa-map-marker{font-size:23px}.footer-navpanel .one-list .fa-chevron-down,.mobile-header .one-list .fa-chevron-down{color:#448339;font-size:14px}.footer-navpanel .one-list:after,.mobile-header .one-list:after{content:"\f078";color:#448339;position:absolute;right:15px;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);font-family:FontAwesome;font-size:13px;-webkit-transition:.2s ease-out;transition:.2s ease-out}.mobile-header .mobile-city-list{margin:0;padding:10px 0;list-style:none;max-height:350px;overflow-y:auto;display:none}.mobile-header .mobile-city-list li{min-height:25px;padding-left:15px;padding-top:3px}.mobile-header .mobile-city-list li.active a{color:#448339;position:relative}.mobile-header .mobile-city-list li.active a:after{content:"\f00c";font-family:FontAwesome;position:absolute;top:4px;right:15px}.mobile-header .mobile-city-list a{color:#535351;line-height:16px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;height:100%;padding-right:35px}.mobile-header .mobile-lang-list{margin:0;padding-left:0;padding-top:10px;padding-bottom:10px;list-style:none;display:none}.mobile-header .mobile-lang-list .fa{color:#bdbcb3;font-size:18px;margin-right:10px}.mobile-header .mobile-lang-list li{height:30px;padding-left:15px}.mobile-header .mobile-lang-list a{color:#535351;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;height:100%}.mobile-header .mobile-menu .menu-list .three-llist a{font-size:14px;color:#565656;padding:8px 0}.fone-poster-box{display:none;position:fixed;width:100%;height:100%;top:0;left:0;margin:auto;z-index:0}.fone-poster-left,.fone-poster-right{position:fixed;top:0;bottom:0;z-index:1;display:block}.fone-poster-left{right:auto;left:50%;margin:0 auto auto -1760px}.fone-poster-right{left:auto;right:50%;margin:0 -1760px auto auto}.mobmenu-panel{max-width:42px;min-width:42px;position:relative}.mobmenu-panel .for-mob-menu-barstext{display:block;font-size:9px;font-weight:600;text-align:center;text-transform:uppercase;letter-spacing:-.3px;position:absolute;bottom:-8px;left:6px}.mobmenu-right-box{min-width:155px;max-width:155px;text-align:right;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.mobmenu-serch-part{width:100%;padding:10px 8px}.mobmenu-wishlistbox{font-size:38px;background-color:transparent;padding:1px 5px;position:relative}.mobmenu-wishlistbox a{color:#bdbcb3}.mobmenu-wishlistbox .my-notebook.wishlist .inscription .for-price{width:22px;text-align:center;color:#fff;position:absolute;top:15px;left:13px;font-size:18px;font-weight:900}.mobmenu-bottom-part{width:100%;color:#535351;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:5px 10px 1px}.mob-fabrics-link{display:inline-block;color:#41403e;text-decoration:none;position:relative}.mob-fabrics-link .for-mobmenu-fabicon .fa{font-size:34px;font-weight:600;color:#bdbcb3}.mob-fabrics-link .for-mobmenu-fabtext{display:block;color:#41403e;font-size:9px;font-weight:600;text-align:center;text-transform:uppercase;letter-spacing:-.3px;position:absolute;bottom:-14px;left:-3px}.mobile-menu .navigation{padding:20px 10px}.mobile-menu .navigation li{list-style:none;border-bottom:1px solid #bed3db}.mobile-menu .navigation li.jshaslist .list-level>li:last-child,.mobile-menu .navigation li.tl-panel{border-bottom:0}.mobile-menu .navigation>li>a{display:block;text-decoration:none;color:#41403e;font-size:18px;padding:10px 25px 10px 0;position:relative}.mobile-menu .navigation li.js-has-list>a:after,.mobile-menu .navigation li.jshaslist>a:after{font-family:FontAwesome;content:"\f107";position:absolute;top:10px;right:10px;-webkit-transition:70ms;transition:70ms}.mobile-menu .navigation li.js-has-list>a.open:after,.mobile-menu .navigation li.jshaslist .list-level>li.open>a:after,.mobile-menu .navigation li.jshaslist>a.open:after{-webkit-transform:rotate(180deg);transform:rotate(180deg)}.mobile-menu .navigation li.js-has-list .list-level,.mobile-menu .navigation li.jshaslist .list-level{padding:2px 10px 6px}.mobile-menu .navigation li.js-has-list .list-level>li,.mobile-menu .navigation li.jshaslist .list-level>li,.mobsearch-group{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.mobile-menu .navigation li.jshaslist .list-level>li{-ms-flex-wrap:wrap;flex-wrap:wrap}.mobile-menu .navigation li.js-has-list .list-level>li>a,.mobile-menu .navigation li.jshaslist .list-level>li>a{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;font-size:15px;text-decoration:none;color:#535351;padding:6px 6px 6px 0}.mobile-menu .navigation li.jshaslist .list-level>li>a{position:relative;padding:8px 0}.mobile-menu .navigation li.jshaslist .list-level>li>a:after{font-family:FontAwesome;content:"\f105";position:absolute;top:9px;right:-12px;-webkit-transition:.3s;transition:.3s}.mobile-menu .navigation li.js-has-list .list-level>li>a .img-cont,.mobile-menu .navigation li.jshaslist .list-level>li>a .img-cont{margin-right:4px}.mobile-menu .navigation li.js-has-list .list-level>li .count,.mobile-menu .navigation li.jshaslist .list-level>li .count{font-size:14px;font-style:italic;color:#777}.mobile-menu .navigation li.jshaslist .list-level>li .count{padding-left:4px}.btn-mobitem-close{display:block;width:100%;font-size:18px;font-weight:600;padding:4px 12px;border:1px solid #f3f2f0;background-color:transparent;margin-bottom:6px;position:relative}.btn-mobitem-close:focus{outline:transparent}.btn-mobitem-close>.fa{position:absolute;top:16px;left:8px}.btn-mobitem-close .for-onelevel-text{display:block;width:100%;font-size:12px;font-style:italic;color:#898989;line-height:14px}.mobile-openbg{display:none;position:fixed;top:0;right:0;bottom:0;left:0;background-color:rgba(0,0,0,.8);z-index:999}.adress-container{width:calc(100% - 155px);min-height:38px;padding-right:6px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;position:relative}.adress-container .js-toggle-list{width:100%;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;margin-left:6px}.adress-container .for-map-icon{color:#bdbcb3;font-size:42px}.adress-container .for-adress-icon{white-space:nowrap;overflow:hidden;display:none;font-size:20px;font-weight:600;color:#444;padding-left:8px}.adress-container .mobile-city-list{position:absolute;top:52px;left:-40px;z-index:999;background-color:#fff;-webkit-box-shadow:0 0 8px rgba(0,0,0,.15);box-shadow:0 0 8px rgba(0,0,0,.15)}.btn-siginout{font-size:40px;color:#bdbcb3}.feedback-container{font-weight:600}.feedback-container .for-fcicon{color:#e60000}.feedback-container .for-fcicon .fa{font-size:16px;font-weight:600}.mobsearch-box{display:none;width:100%;padding:10px;background-color:#535351}.btn-mobsearch{display:inline-block;font-family:Vollkorn,sans-serif;font-weight:700;font-size:16px;padding:5px 20px;background-color:#bdbcb3;color:#fff;border:1px solid #bdbcb3}.btn-mobsearch:focus{text-decoration:none;border-color:#448339}.home-main .top-home-img,.img-cont{position:relative}.home-top-slider{min-height:560px;max-height:560px;overflow:hidden;width:100%}.home-top-slider .img-cont span{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%);display:block;font-family:Vollkorn,sans-serif;font-size:35px;color:#f2f2f2;text-shadow:1px 1px 9px rgba(0,0,0,.8);text-transform:uppercase;width:100%;text-align:center;pointer-events:none}.home-top-slider .img-cont img{width:100%;height:auto;min-height:560px;max-height:560px;-o-object-fit:cover;object-fit:cover}.home-top-slider .slick-dots{padding-left:0;display:-webkit-box;display:-ms-flexbox;display:flex;list-style:none;font-size:0;position:absolute;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%);bottom:0}.home-top-slider .slick-dots li{width:10px;height:10px;border-radius:5px;overflow:hidden;margin-right:15px}.home-top-slider .slick-dots li button{height:100%;width:100%;border:none;background:#fff}.contact-partner-slider .slick-arrow,.home-top-slider .slick-arrow{position:absolute;top:50%;z-index:99;cursor:pointer;background-size:27px 44px;background-position:center;background-repeat:no-repeat;background-color:rgba(255,255,255,.4);border:1px solid rgba(0,0,0,.04);width:40px;height:40px;border-radius:2px;display:-ms-flexbox;display:-webkit-box;display:flex;-ms-flex-align:center;-webkit-box-align:center;align-items:center;-ms-flex-pack:center;-webkit-box-pack:center;justify-content:center;margin-top:-20px;outline:transparent}.contact-partner-slider .slick-arrow.slick-prev,.home-top-slider .slick-arrow.slick-prev{left:10px;padding-left:3px}.contact-partner-slider .slick-arrow.slick-nex:center;-webkit-box-pack:center;justify-content:center;margin-top:-20px;outline:transparent}.contact-partner-slider .slick-arrow.slick-prev,.home-top-slider .slick-arrow.slick-prev{left:10px;padding-left:3px}.contact-partner-slider .slick-arrow.slick-next,.home-top-slider .slick-arrow.slick-next{right:10px;padding-right:3px}.contact-partner-slider .slick-arrow.slick-prev:before,.home-top-slider .slick-arrow.slick-prev:before{font-family:FontAwesome;content:"\f053";font-size:20px;line-height:1;opacity:.75;color:#000}.contact-partner-slider .slick-arrow.slick-next:before,.home-top-slider .slick-arrow.slick-next:before{font-family:FontAwesome;content:"\f054";font-size:20px;line-height:1;opacity:.75;color:#000}.articles-list .section-header,.home-main .section-header{height:125px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.articles-list .section-header .sticker,.home-main .section-header .sticker{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-ms-flex-wrap:nowrap;flex-wrap:nowrap;white-space:nowrap;height:33px;background:#448339;font-size:13px;text-transform:uppercase;padding-left:40px;padding-right:40px;color:#fff;font-weight:500;text-decoration:none}.home-main .numbers,.home-main .numbers .img-cont,.home-main .numbers .title{display:-webkit-box;display:-ms-flexbox}.home-main .search{background:#448339;color:#fff;font-size:13px;text-transform:uppercase;border:none;min-width:160px;font-weight:600;border-bottom-right-radius:4px}.home-main .filter .filter-price .search{border-bottom-right-radius:0;min-width:130px}.articles-list .section-title,.home-main .section-title{font-size:35px;color:#535351;line-height:27px;font-family:Vollkorn,sans-serif;font-weight:500;margin:0 15px 0 0;text-transform:none}.home-main .numbers{display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;min-height:194px}.home-main .numbers .one-number{max-width:210px;overflow:hidden}.home-main .numbers .title{font-size:115px;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;color:#e3e0d5;font-weight:500;font-family:Vollkorn,sans-serif}.home-main .numbers .img-cont{height:105px;width:105px;position:relative;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;margin-left:15px;margin-top:22px}.home-main .numbers .img-cont img{max-height:100%;max-width:100%;height:auto;width:auto;display:block}.home-main .numbers .descr{font-size:15px;line-height:25px;color:#41403e;margin-top:-23px}.home-main .best-price .after-text{background:#f3f2f0;padding:65px 55px;color:#41403e;font-size:24px;line-height:36px;display:-webkit-box;display:-ms-flexbox;display:flex;margin-top:100px}.home-main .best-price .img-container{position:relative;min-width:350px;margin-right:60px}.home-main .best-price .img-container img{position:absolute;width:100%;height:auto;bottom:-50px;left:0}.home-main .sale-sect .img-cont img{display:block;max-height:100%;max-width:100%;height:auto;width:auto;position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.footer .cities-list .list-of-cities{-webkit-column-count:7;-moz-column-count:7;column-count:7;padding-bottom:50px;border-bottom:1px solid #bdbcb3}.footer .cities-list .list-of-cities>span{font-size:18px;font-weight:500}.order_status_failure{color:#cf2028}@media(min-width:1900px){.fone-poster-box{display:block}#top.header .container-wrap,.container-wrap,.footer .container-wrap{position:relative;z-index:2}}@media(min-width:1301px){.header .autorized .wishlist{margin-right:45px}}@media(min-width:1200px){.large-container{width:100%;max-width:1400px}}@media screen and (min-width:992px){header #main-menu{height:auto!important}}@media(min-width:769px){.home-main .top-home-img{background-image:url(../img/baner1.jpg);background-repeat:repeat;background-position:center center;background-size:cover;min-height:560px}.fixed-header{padding-top:46px}}@media(min-width:359px){.feedback-container{font-size:17.7px}.mobile-header .phone-num{font-size:16px}}@media(min-width:350px){.feedback-container{min-width:50%;border-right:3px solid #bdbcb3}}@media (max-width:1300px){.header .bot-header .navigation .list-level a,.header .bot-header .navigation a{font-size:14px}.header .search-cont{min-width:230px}.header .search-cont .search-group{width:230px}.header .bot-header .navigation .list-level{padding:40px 70px 45px}.header .bot-header .navigation .list-level li{width:250px;margin-right:12%}.header .bot-header .navigation .list-level li .img-cont{height:21px;width:21px;margin-right:10px}.home-main .categories-sect .one-cat{max-width:285px;width:285px}.home-main .sale-sect .one-sale{width:calc(25% - 20px)}.header .autorized .wishlist{padding-right:0}.home-top-slider,.home-top-slider .img-cont img{min-height:43vw;max-height:43vw}.home-top-slider .img-cont span{font-size:2.69vw}.home-top-slider .slick-arrow{width:3.076vw;height:3.076vw;margin-top:-1.538vw}.home-top-slider .slick-arrow.slick-prev{padding-right:.461vw;padding-left:.23vw}.home-top-slider .slick-arrow.slick-next{padding-right:.23vw;padding-left:.461vw}.home-top-slider .slick-arrow.slick-next:before,.home-top-slider .slick-arrow.slick-prev:before{font-size:1.538vw}}@media(max-width:1200px){header #main-menu a{font-size:14px;padding:15px 5px}header .logo{width:220px;min-width:220px}.header .top-header .phone{font-size:12px}.header .top-header .descr{font-size:8px}.header .phone-num .fa{font-size:18px;margin-right:10px}.header .back-call,.header .select-city .js-select-city{padding:0 10px;font-size:12px}.header .back-call .fa,.header .select-city .fa{font-size:18px}.header .company-logo{width:80px}.header .bot-header .navigation a{font-size:12px;padding:10px 7px}.header .bot-header .navigation .list-level{padding:25px 40px 30px}.header .bot-header .navigation .list-level li{width:220px;height:30px;font-size:13px}.header .search-cont{width:230px;min-width:230px}.header .search-cont .search-group{width:230px}.header .search-cont .search-group input{width:calc(100% - 32px)}.home-main .numbers .title{font-size:90px}.home-main .numbers .img-cont{height:90px;width:90px}.home-main .numbers .descr{font-size:13px;line-height:normal;margin-top:-10px}.home-main .numbers .one-number{max-width:165px}.articles-list .section-title,.home-main .section-title{font-size:28px}.home-main .best-price .img-container img{bottom:-10px}.home-main .best-price .after-text{padding:30px;font-size:21px;line-height:normal}.footer .cities-list .list-of-cities{-webkit-column-count:6;-moz-column-count:6;column-count:6}}@media(max-width:992px){.header .sign-in .fa,.header .wishlist .fa{margin-right:0}.header .wishlist{font-size:0;padding:0 13px}.header .back-call{font-size:0}.header .back-call .fa{font-size:20px}.header .logo{max-width:200px;min-width:200px}.header .top-header .left-part .logo{padding-top:9px}.header .bot-header .navigation .list-level li{width:185px;margin-right:8%}.header .bot-header .navigation .list-level li .img-cont{margin-right:5px}.header .bot-header .navigation .list-level a{font-size:13px}.home-main .numbers{-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.articles-list .section-title,.home-main .section-title{font-size:24px}.home-main .best-price .after-text{font-size:18px}.footer .cities-list .list-of-cities{-webkit-column-count:5;-moz-column-count:5;column-count:5}}@media(max-width:800px){.header .search-cont .search-group{width:180px}.header .search-cont{width:140px;min-width:140px}}@media(max-width:799px){.header .top-header .left-part .logo{max-width:160px;min-width:160px;margin-top:2px}}@media(max-width:768px){.header{display:none}.mobile-header{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap}.articles-list .section-title,.home-main .section-title{color:#535351;font-size:20px;line-height:26px}.home-main .best-price .img-container img{bottom:auto;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.home-main .best-price .after-text{font-size:16px;padding:20px}.footer .cities-list .list-of-cities{-webkit-column-count:4;-moz-column-count:4;column-count:4}}@media(max-width:540px){.home-main .numbers .one-number{max-width:none}.home-main .numbers .slick-dots{margin:0;padding:0;list-style:none;display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important}.home-main .numbers .slick-dots li{margin-right:13px}.home-main .numbers .slick-dots li:last-child{margin-right:0}.home-main .numbers .slick-dots li.slick-active button{background:#448339}.home-main .numbers .slick-dots li button{font-size:0;border:none;background:#e3e0d5;width:16px;height:16px;border-radius:8px}.home-main .numbers .title{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.home-main .numbers .descr{text-align:center}.articles-list .section-title,.home-main .section-title{margin-right:0;font-size:20px;line-height:26px;text-align:center;margin-bottom:20px}.home-main .best-price{margin-bottom:30px}.home-main .best-price .img-container img{position:static;-webkit-transform:translate(0,0);transform:translate(0,0)}.home-main .best-price .after-text{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;font-size:17px;line-height:30px;font-weight:300;margin-top:50px}.cities-list .dropdown.open{overflow:initial!important}.footer .list-of-cities{display:none}.js-filter-modal .filters form{margin-bottom:95px}.articles-list .section-header{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;height:90px}}@media(max-width:400px){.adress-container .for-adress-icon{padding-left:6px}}@media (max-width:480px){.mobile-header .mobile-menu .menu-list .three-llist a,.mobile-menu .navigation li.jshaslist .list-level>li>a{font-size:4.2vw}.mobile-header .mobile-menu .menu-list a{font-size:5.4vw}.btn-mobitem-close{font-size:5.1vw}}@media (max-width:380px){.mobile-header .mobile-menu .menu-list a{font-size:5.5vw}.mobile-menu .navigation li.jshaslist .list-level>li>a{font-size:4.8vw}.mobile-header .mobile-menu .menu-list .three-llist a{font-size:5vw}}@media(max-width:369px){.mobmenu-right-box{min-width:145px;max-width:145px}.adress-container{width:calc(100% - 145px)}}@media(max-width:355px){.mobile-header .left-info-part.mobmenu-part{width:142px}.mobile-header .mobmenu-part .menu-btn{margin-right:10px}.mobile-header .right-btn-part.mobmenu-part{width:calc(100% - 142px)}.mobmenu-right-box{min-width:125px;max-width:125px}.adress-container{width:calc(100% - 125px)}}@media(max-width:339px){.mobile-header .phone-num{font-size:16px}}.article-img{margin-top:15px;overflow:hidden;border-radius:4px}.article-img img{width:100%;height:auto}.sale-block{background-color:#c4252f;text-transform:uppercase;color:#fff;position:absolute;z-index:10;right:-38px;bottom:20px;width:135px;text-align:center;-webkit-transform:rotate(315deg);transform:rotate(315deg)}.fa{display:inline-block;font:14px/1 FontAwesome;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.fa-bars:before{content:"\f0c9"}.fa-map-marker:before{content:"\f041"}.fa-user-o:before{content:"\f2c0"}.fa-heart-o:before{content:"\f08a"}.fa-industry:before{content:"\f275"}.fa-envelope-o:before{content:"\f003"}*{-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}.form-control{display:block;width:100%;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:160px;padding:5px 0;margin:2px 0 0;font-size:14px;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.15);border-radius:4px;-webkit-box-shadow:0 6px 12px rgba(0,0,0,.175);box-shadow:0 6px 12px rgba(0,0,0,.175)}.category-page .sort-by .dropdown-menu,.categoty-page .sort-by .dropdown-menu{right:0;left:auto}.comp-advanteges p{text-indent:0;margin:11px 0}
    </style>
    <!-- font awesome -->
    <link href="/css/font-awesome/css/font-awesome.min.css?v=1.0.1" rel="stylesheet">
    <!-- bootstrap -->
    <link href="/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- end preloader styles -->
    <script>var mobMenuData = {};</script>
    <?php $this->head(); ?>
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" type="text/javascript"
            charset="UTF-8"></script>
    <![endif]-->
</head>
<body <?= DOMAIN_TYPE == 'co.il' ? ' style="direction: rtl;"' : '' ?>>
<?php $this->beginBody() ?>

<?= Popup::widget(['clientOptions' => ['show' => true]]) ?>

<?= $this->render('parts/_header', ['bundle' => $bundle]) ?>

<?= BackgroundBanner::widget([
    'city_id' => Yii::$app->city->getCityId()
]); ?>

<?= $content ?>

<?= $this->render('parts/_footer', []) ?>

<?= $this->render('parts/_jivosite', []) ?>

<?= $this->render('parts/_yandex_metrika', []) ?>

<?= $this->render('parts/_google_metrika', []) ?>

<?= $this->render('parts/_cookie', []) ?>

<input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">


<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
<?php \defyma\helper\Minifier::end(); ?>
