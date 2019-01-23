<?php

use yii\helpers\{
    Html, Url
};

?>
<ul class="nav navbar-nav navbar-right">
    <li>
        <div class="my-notebook dropdown">
            <span class="red-but notebook-but dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars" aria-hidden="true"></i>
                <?= Yii::t('app', 'Menu') ?>
                <object>
                    <ul class="dropdown-menu">

                        <?php if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['partner'])) { ?>
<!--                            <li>-->
<!--                                --><?//= Html::a(
//                                    'Мебель в Италии',
//                                    ['/catalog/italian-product/list']
//                                ); ?>
<!--                            </li>-->
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Orders'),
                                    ['/shop/partner-order/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Sale'),
                                    ['/catalog/partner-sale/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Размещение кода'),
                                    ['/page/page/view', 'alias' => 'razmeshchenie-koda']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Инструкция партнерам'),
                                    ['/page/page/view', 'alias' => 'instructions']
                                ); ?>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Profile'),
                                    ['/user/profile/index']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Sign Up'),
                                    ['/user/logout/index']
                                ); ?>
                            </li>
                        <?php } elseif (Yii::$app->getUser()->getIdentity()->group->role == 'admin') { ?>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Orders'),
                                    ['/shop/admin-order/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Product statistics'),
                                    ['/catalog/product-stats/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Factory statistics'),
                                    ['/catalog/factory-stats/list']
                                ); ?>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Profile'),
                                    ['/user/profile/index']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Sign Up'),
                                    ['/user/logout/index']
                                ); ?>
                            </li>
                        <?php } elseif (Yii::$app->getUser()->getIdentity()->group->role == 'factory') { ?>
<!--                            <li>-->
<!--                                --><?//= Html::a(
//                                    'Мебель в Италии',
//                                    ['/catalog/italian-product/list']
//                                ); ?>
<!--                            </li>-->
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'My goods'),
                                    ['/catalog/factory-product/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Collections'),
                                    ['/catalog/factory-collections/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Рекламные кампании'),
                                    ['/catalog/factory-promotion/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Orders'),
                                    ['/shop/factory-order/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Product statistics'),
                                    ['/catalog/product-stats/list']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Factory statistics'),
                                    ['/catalog/factory-stats/list']
                                ); ?>
                            </li>
                            <?php
                            /*
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Banners'),
                                    ['/banner/factory-banner/list']
                                ); ?>
                            </li>
                            */
                            ?>


                            <li role="separator" class="divider"></li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Profile'),
                                    ['/user/profile/index']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Sign Up'),
                                    ['/user/logout/index']
                                ); ?>
                            </li>
                        <?php } else { ?>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Orders'),
                                    ['/shop/order/list']
                                ); ?>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Profile'),
                                    ['/user/profile/index']
                                ); ?>
                            </li>
                            <li>
                                <?= Html::a(
                                    Yii::t('app', 'Sign Up'),
                                    ['/user/logout/index']
                                ); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </object>
            </span>
        </div>
    </li>
</ul>