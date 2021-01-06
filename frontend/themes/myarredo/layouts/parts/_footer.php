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
<link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400;0,500;0,700;0,800;1,400&display=swap" rel="stylesheet">
<div class="footer jsftr" data-url="<?= $url; ?>">
    <div class="container-wrap">

        <?php if (!in_array(DOMAIN_TYPE, ['com', 'de', 'kz', 'co.il']) && !in_array(Yii::$app->controller->id, ['sale'])) { ?>
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
        } else if (!in_array(DOMAIN_TYPE, ['com', 'de', 'kz', 'co.il'])) {
            if ($this->beginCache('CitiesWidget' . Yii::$app->city->getCityId() . Yii::$app->language, ['duration' => 7200])) {
                echo Cities::widget();
                $this->endCache();
            }
        } ?>

        <div class="footer-navpanel">
            <div class="bot-list">
                <?php if (DOMAIN_NAME == 'myarredo' &&
                    in_array(DOMAIN_TYPE, ['ru', 'by', 'ua', 'com', 'de', 'co.il']) &&
                    !in_array(Yii::$app->controller->id, ['articles', 'contacts', 'sale'])
                ) { ?>
                    <div class="one-list-cont lang-cont">
                        <?= LangSwitch::widget(['view' => 'lang_switch_mobile', 'noIndex' => $this->context->noIndex]) ?>
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

                        <?= Html::a(
                            Html::img($bundle->baseUrl . '/img/logo.svg'),
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
                            } elseif (!in_array(DOMAIN_TYPE, ['com', 'de', 'kz', 'co.il'])) {
                                echo Menu::widget(['alias' => 'footer']);
                            } elseif (in_array(DOMAIN_TYPE, ['com', 'de', 'kz', 'co.il'])) {
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

<?php if (DOMAIN_TYPE == 'ru' && Yii::$app->getUser()->isGuest) { ?>
    <script type="text/javascript">
        var __cs = __cs || [];
        __cs.push(["setCsAccount", "UmbSor8qhGbovgqKXcAqTSVMMinwFmSy"]);
    </script>
    <script type="text/javascript" async src="https://app.uiscom.ru/static/cs.min.js"></script>
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
<!-- Falling snow script -->
<script>
    console.time('speed falling-snow js');
      var snowmax=35;
      var snowcolor=new Array("#AAAACC","#DDDDFF","#CCCCDD","#F3F3F3","#F0FFFF","#FFFFFF","#EFF5FF")
      var snowtype=new Array("Arial Black","Arial Narrow","Times","Comic Sans MS");
      var snowletter="*";
      var sinkspeed=0.6; 
      var snowmaxsize=40;
      var snowminsize=8;
      var snowingzone=1;
      
      
      var snow=new Array();
      var marginbottom;
      var marginright;
      var timer;
      var i_snow=0;
      var x_mv=new Array();
      var crds=new Array();
      var lftrght=new Array();
      var browserinfos=navigator.userAgent;
      var ie5=document.all&&document.getElementById&&!browserinfos.match(/Opera/);
      var ns6=document.getElementById&&!document.all;
      var opera=browserinfos.match(/Opera/);
      var browserok=ie5||ns6||opera;
      function randommaker(range) {
          rand=Math.floor(range*Math.random());
          return rand;
      }
      function initsnow() {
          if (ie5 || opera) {
              marginbottom=document.body.clientHeight;
              marginright=document.body.clientWidth;
          }
          else if (ns6) {
              marginbottom=window.innerHeight;
              marginright=window.innerWidth;
          }
          var snowsizerange=snowmaxsize-snowminsize;
          for (i=0;i<=snowmax;i++) {
              crds[i]=0;
              lftrght[i]=Math.random()*15;
              x_mv[i]=0.03+Math.random()/10;
              snow[i]=document.getElementById("s"+i);
              snow[i].style.fontFamily=snowtype[randommaker(snowtype/length)];
              snow[i].size=randommaker(snowsizerange)+snowminsize;
              snow[i].style.fontSize=snow[i].size+"px";
              snow[i].style.color=snowcolor[randommaker(snowcolor.length)];
              snow[i].sink=sinkspeed*snow[i].size/5;
              if (snowingzone==1) {snow[i].posx=randommaker(marginright-snow[i].size)}
              if (snowingzone==2) {snow[i].posx=randommaker(marginright/2-snow[i].size)}
              if (snowingzone==3) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/4}
              if (snowingzone==4) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/2}
              snow[i].posy=randommaker(2*marginbottom-marginbottom-2*snow[i].size);
              snow[i].style.left=snow[i].posx+"px";
              snow[i].style.top=(snow[i].posy ) +"px";
          }
          movesnow();
      }
      function movesnow() {
          for(i=0;i<=snowmax;i++) {
              crds[i]+=x_mv[i];
              snow[i].posy+=snow[i].sink;
              snow[i].style.left=snow[i].posx+lftrght[i]*Math.sin(crds[i])+"px";
              snow[i].style.top=snow[i].posy+"px";
              if (snow[i].posy>=marginbottom-2*snow[i].size || parseInt(snow[i].style.left)>(marginright-3*lftrght[i])) {
                  if (snowingzone==1) {snow[i].posx=randommaker(marginright-snow[i].size)}
                  if (snowingzone==2) {snow[i].posx=randommaker(marginright/2-snow[i].size)}
                  if (snowingzone==3) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/4}
                  if (snowingzone==4) {snow[i].posx=randommaker(marginright/2-snow[i].size)+marginright/2}
                  snow[i].posy=0;
              }
          }
          var timer=setTimeout("movesnow()",50);
      }
      for (i=0;i<=snowmax;i++) {
          document.write("<span id='s"+i+"' style='z-index:9;pointer-events:none;opacity:0.8;position:fixed;top:-"+snowmaxsize+"px;'>"+snowletter+"</span>");
      }
      if (browserok) {
          window.onload=setTimeout(function() {
              initsnow();
          },2000);
      }
    console.timeEnd('speed falling-snow js');
</script>
<!-- end Falling snow script -->
