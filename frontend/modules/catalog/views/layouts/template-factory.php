<?php

use yii\helpers\{
    Url, Html
};
use frontend\themes\myarredo\assets\TemplateFactoryAsset;
use frontend\themes\myarredo\widgets\Alert;
use frontend\modules\catalog\models\Factory;
use frontend\modules\user\widgets\partner\PartnerInfo;

$bundle = TemplateFactoryAsset::register($this);

$this->beginPage()

?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <base href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= $this->title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php $this->head(); ?>
        <input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
        <![endif]-->
    </head>
    <body class="tomassy-page">
    <?php $this->beginBody() ?>

    <?= Alert::widget() ?>

    <div class="tom-header">
        <div class="container large-container">
            <div class="top-topm-header flex">
                <div class="logo-cont">
                    <?= Html::img(Factory::getImage($this->context->factory['image_link'])); ?>
                </div>

                <?= Html::tag(
                    'h3',
                    $this->context->factory['lang']['h1'] . ', купить в ' . Yii::$app->city->getCityTitleWhere()
                ); ?>

            </div>
            <a href="tel:<?= Yii::$app->partner->getPartnerPhone() ?>" class="tel">
                <?= Yii::$app->partner->getPartnerPhone() ?>
            </a>
            <nav class="nav">
                <?= Html::a('Главная', ['/catalog/factory/view', 'alias' => $this->context->factory['alias']]); ?>
                <?= Html::a('Каталог мебели', ['/catalog/template-factory/catalog', 'alias' => $this->context->factory['alias']]); ?>
                <?= Html::a(Yii::t('app', 'Sale'), ['/catalog/template-factory/sale', 'alias' => $this->context->factory['alias']]); ?>
                <?= Html::a('Контанты', ['/catalog/template-factory/contacts', 'alias' => $this->context->factory['alias']]); ?>
            </nav>
        </div>
    </div>

    <?= $content ?>

    <div class="top-footer">
        <div class="container large-container">

            <?php if (!in_array(Yii::$app->controller->action->id, ['sale', 'sale-product'])): ?>
                <?= PartnerInfo::widget(['view' => 'template_factory_partner_info']) ?>
            <?php endif; ?>

            <div class="flex copy-r">
                <div>
                    2015 - <?= date('Y'); ?> (С) MYARREDO, ЛУЧШАЯ МЕБЕЛЬ ИЗ ИТАЛИИ ДЛЯ ВАШЕГО ДОМА
                </div>
                <div>
                    <?= $this->context->factory['lang']['h1'] . ', купить в ' . Yii::$app->city->getCityTitleWhere() ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>