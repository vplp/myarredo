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
use frontend\modules\forms\widgets\FormFeedback;

$bundle = AppAsset::register($this);

?>

    <div class="footer">
        <div class="container-wrap">

            <?php if (Yii::$app->controller->id !== 'sale') { ?>
                <div class="contacts">
                    <div class="cont-flex">
                        <div class="cont-info">
                            <div class="cont-info-in">
                                <div class="cont-info-border">
                                    <h4><?= Yii::t('app', 'Contacts') ?></h4>

                                    <?= PartnerInfo::widget() ?>

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

                        <?= Html::a(
                            Yii::t('app', 'View all sales offices'),
                            Url::toRoute('/page/contacts/list-partners')
                        ); ?>
                    </div>
                </div>

            <?php } ?>

            <?php if (Yii::$app->controller->action->id != 'list-partners') {
                echo PartnerMap::widget(['city' => Yii::$app->city->getCity()]);
            } ?>

            <?= Cities::widget() ?>

            <div class="bot-footer">
                <div class="container large-container">
                    <div class="footer-cont">
                        <div class="logo-reg">
                            <a href="/" class="logo">
                                <img src="<?= $bundle->baseUrl ?>/img/logo.svg" alt="">
                            </a>

                            <?= topBarInfo::widget() ?>

                            <?= FormFeedback::widget() ?>

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

                                <?php if (Yii::$app->city->domain == 'by'): ?>

                                    2013 - <?= date('Y'); ?> (с)
                                    <?= str_replace(['#городе#', '#nella citta#'], Yii::$app->city->getCityTitleWhere(), Yii::$app->param->getByName('FOOTER_COPYRIGHT_BY')); ?></br>

                                <?php elseif (Yii::$app->city->domain == 'ua'): ?>

                                    2013 - <?= date('Y'); ?> (с)
                                    <?= str_replace(['#городе#', '#nella citta#'], Yii::$app->city->getCityTitleWhere(), Yii::$app->param->getByName('FOOTER_COPYRIGHT_UA')); ?></br>

                                <?php else: ?>

                                    2013 - <?= date('Y'); ?> (с)
                                    <?= str_replace(['#городе#', '#nella citta#'], Yii::$app->city->getCityTitleWhere(), Yii::$app->param->getByName('FOOTER_COPYRIGHT_RU')); ?></br>

                                <?php endif; ?>

                                <?= Yii::t('app', 'Программирование сайта') ?> -
                                <a href="http://www.vipdesign.com.ua/" rel="nofollow">VipDesign</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"></div>

<?php
/**
 * сервис заказа обратного звонка
 */
if (Yii::$app->getUser()->isGuest && Yii::$app->city->domain == 'test' &&
    !in_array(Yii::$app->controller->id, ['sale'])
) { ?>
    <script type="text/javascript">
        var __cs = __cs || [];
        __cs.push(["setCsAccount", "KNKIlw22peShQSsYcaBCDumFwgrDNrWx"]);
    </script>
    <script type="text/javascript" async src="//app.comagic.ru/static/cs.min.js"></script>
<?php } ?>