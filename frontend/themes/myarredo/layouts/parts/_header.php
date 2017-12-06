<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\widgets\menu\CatalogMenu;
use frontend\modules\shop\widgets\cart\Cart;
use frontend\modules\location\widgets\ChangeCity;

?>

<header>

    <?php if ((Yii::$app->getUser()->isGuest)): ?>

        <?= ChangeCity::widget() ?>

        <div class="top-navbar">
            <div class="container large-container">
                <div class="row">
                    <ul class="nav navbar-nav top-panel flex">
                        <li class="tel-num">
						<span>
							<i class="glyphicon glyphicon-earphone"></i> <?= Yii::$app->partner->getPartnerPhone() ?>
						</span>
                        </li>
                        <li>
                            <a class="callback-trigger" href="javascript:void(0);">
							<span>
								Обратный звонок
							</span>
                            </a>
                        </li>
                        <li class="geo">
                            <a href="javascript: void(0);" id="select-city">
                                <i class="glyphicon glyphicon-map-marker"></i>
                                <span class="country">
								<?= Yii::$app->city->getCountryTitle() ?>
							</span>
                                <span class="city">
								<?= Yii::$app->city->getCitytitle() ?>
							</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="short_cart">
                            <?= Cart::widget(['view' => 'short']) ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="top-navbar">
            <div class="container large-container">
                <div class="row">
                    <?php //if (Yii::$app->getUser()->getIdentity()->group->role == 'user'): ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="short_cart">
                            <?= Cart::widget(['view' => 'short']) ?>
                        </li>
                    </ul>
                    <?php //endif; ?>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <div class="my-notebook dropdown">
                            <span class="red-but notebook-but dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                                Меню
                                <object>
                                    <ul class="dropdown-menu">

                                        <?php if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['partner'])): ?>

                                            <li>
                                                <?= Html::a('Города', ['/catalog/partner-sale/mailing-by-cities']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Заявки', ['/shop/partner-order/list']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Распродажа', ['/catalog/partner-sale/list']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Размещение кода', ['/catalog/partner-sale/code']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Инструкция партнерам', ['/catalog/partner-sale/instructions']); ?>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <?= Html::a('Профиль', ['/user/profile/index']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a(Yii::t('app', 'Sign Up'), ['/user/logout/index']); ?>
                                            </li>
                                        <?php elseif (Yii::$app->getUser()->getIdentity()->group->role == 'admin'): ?>
                                            <li>
                                                <?= Html::a('Заявки', ['/shop/partner-order/list']); ?>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <?= Html::a('Профиль', ['/user/profile/index']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a(Yii::t('app', 'Sign Up'), ['/user/logout/index']); ?>
                                            </li>
                                        <?php elseif (Yii::$app->getUser()->getIdentity()->group->role == 'factory'): ?>

                                            <li>
                                                <?= Html::a('Каталог', ['/user/profile/index']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Коллекции', ['/user/profile/index']); ?>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <?= Html::a('Профиль', ['/user/profile/index']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a(Yii::t('app', 'Sign Up'), ['/user/logout/index']); ?>
                                            </li>

                                        <?php else: ?>

                                            <li>
                                                <?= Html::a('Заказы', ['/shop/order/list']); ?>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <?= Html::a('Профиль', ['/user/profile/index']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a(Yii::t('app', 'Sign Up'), ['/user/logout/index']); ?>
                                            </li>

                                        <?php endif; ?>
                                    </ul>
                                </object>
                            </span>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    <?php endif; ?>

    <nav class="navbar">
        <div class="container large-container">
            <div class="row">
                <a href="/" class="logo">
                    <img src="<?= $bundle->baseUrl ?>/img/logo.svg" alt="">
                </a>
                <?= CatalogMenu::widget([]); ?>
            </div>
        </div>
    </nav>
</header>