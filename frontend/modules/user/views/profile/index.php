<?php

use yii\helpers\{
    Html, Url
};
use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);

/**
 * @var \frontend\modules\user\models\Profile $model
 */

$this->title = Yii::t('app', 'Profile');

?>

<main>
    <div class="page factory-profile">
        <div class="largex-container profile-gencont">

            <?= Html::tag('h1', $this->title, ['class' => 'title-h1-profile']); ?>

            <div class="part-contact">
                <div class="part-contact-left">
                    <div class="part-contact-left-imgbox">
                        <div class="profile-imgbox-img">
                            <?= Html::img($bundle->baseUrl . '/img/profile_user_img.jpg') ?>
                        </div>
                    </div>
                    <div class="part-contact-left-formbox">
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'phone') ?>
                            <span class="for-profile-form"><?= $model['phone'] ?></span>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'first_name') ?>
                            <span class="for-profile-form"><?= $model['first_name'] ?></span>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'last_name') ?>
                            <span class="for-profile-form"><?= $model['last_name'] ?></span>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'email') ?>
                            <span class="for-profile-form"><?= $model['user']['email'] ?></span>
                        </div>

                        <div class="panel-btn-profile">
                            <?= Html::a(Yii::t('app', 'Edit'), ['/user/profile/update'], [
                                'class' => 'btn btn-green first'
                            ]) ?>
                            <?= Html::a(Yii::t('user', 'Change password'), ['/user/password/change'], [
                                'class' => 'btn btn-green'
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="part-contact-right">

                    <?php if (Yii::$app->session->has("newUserFactory")) {
                        Yii::$app->session->remove("newUserFactory");
                        ?>

                        <div class="welcome-box">
                            <div class="welcome-left">
                                <?= Html::img($bundle->baseUrl . '/img/thank_register.png') ?>
                            </div>
                            <div class="welcome-right">
                                <?= Yii::$app->param->getByName('USER_FACTORY_REG_CONGRATULATIONS') ?>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="profile-box">

                            <?php if (in_array(Yii::$app->user->identity->group->role, ['logistician'])) { ?>
                                <a href="<?= Url::toRoute(['/shop/partner-order/list-italy'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/requests.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Orders italy') ?>
                                    </div>
                                </a>
                            <?php } elseif (in_array(Yii::$app->user->identity->group->role, ['partner']) &&
                                Yii::$app->user->identity->profile->country_id == 4 &&
                                in_array(Yii::$app->language, ['it-IT', 'en-EN'])
                            ) { ?>
                                <a href="<?= Url::toRoute(['/catalog/italian-product/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/my_products.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Furniture in Italy') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/shop/partner-order/list-italy'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/requests.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Orders italy') ?>
                                    </div>
                                </a>
                            <?php }
                            if (in_array(Yii::$app->user->identity->group->role, ['partner'])) { ?>
                                <a href="<?= Url::toRoute(['/catalog/italian-product/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/my_products.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Furniture in Italy') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/catalog/partner-sale/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/my_products.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Sale') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/shop/partner-order/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/requests.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Orders') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/payment/partner-payment/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/statistics_factorys.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Платежная информация') ?>
                                    </div>
                                </a>
                            <?php } elseif (Yii::$app->user->identity->group->role == 'admin') { ?>
                                <a href="<?= Url::toRoute(['/shop/admin-order/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/requests.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Orders') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/catalog/product-stats/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/statistics_prods.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Product statistics') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/catalog/factory-stats/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/statistics_factorys.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Factory statistics') ?>
                                    </div>
                                </a>
                            <?php } elseif (Yii::$app->user->identity->group->role == 'factory') { ?>
                                <a href="<?= Url::toRoute(['/catalog/factory-product/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/my_products.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'My goods') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/catalog/factory-collections/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/collections.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Collections') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/catalog/factory-promotion/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/reclams_campany.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Рекламные кампании') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/shop/factory-order/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/requests.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Orders') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/catalog/product-stats/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/statistics_prods.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Product statistics') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/catalog/factory-stats/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/statistics_factorys.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Factory statistics') ?>
                                    </div>
                                </a>
                                <a href="<?= Url::toRoute(['/payment/partner-payment/list'], true) ?>"
                                   class="profile-quadrlink">
                                    <div class="profile-quadrlink-img">
                                        <?= Html::img($bundle->baseUrl . '/img/statistics_factorys.png') ?>
                                    </div>
                                    <div class="profile-quadrlink-text">
                                        <?= Yii::t('app', 'Платежная информация') ?>
                                    </div>
                                </a>
                            <?php } ?>

                            <a href="<?= Url::toRoute(['/user/logout/index'], true) ?>" class="profile-quadrlink">
                                <div class="profile-quadrlink-img">
                                    <?= Html::img($bundle->baseUrl . '/img/come_out.png') ?>
                                </div>
                                <div class="profile-quadrlink-text">
                                    <?= Yii::t('app', 'Sign Up') ?>
                                </div>
                            </a>

                            <div class="profile-quadrlink"></div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</main>
