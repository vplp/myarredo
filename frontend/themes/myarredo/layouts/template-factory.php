<?php

use yii\helpers\{
    Url, Html
};
use frontend\themes\myarredo\assets\TemplateFactoryAsset;
use frontend\widgets\Popup;
use frontend\modules\catalog\models\Factory;
use frontend\modules\user\widgets\partner\PartnerInfo;

$bundle = TemplateFactoryAsset::register($this);

$this->beginPage()

?>
<!DOCTYPE html>
<html lang="<?= substr(Yii::$app->language, 0, 2) ?>">
<head>
    <base href="<?= Yii::$app->getRequest()->hostInfo . Url::toRoute(['/']) ?>">
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= $this->title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->head(); ?>
    <input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>
<body class="tomassy-page category-page">
<?php $this->beginBody() ?>

<?= Popup::widget() ?>

<div class="tom-header">
    <div class="container large-container">
        <div class="top-topm-header flex">
            <div class="logo-cont">
                <?= Html::a(
                    Html::img(Factory::getImage($this->context->factory['image_link'])),
                    ['/catalog/factory/view', 'alias' => $this->context->factory['alias']]
                ) ?>
            </div>

            <?php if (isset($this->context->factory['lang'])) {
                echo Html::tag(
                    'h3',
                    $this->context->factory['lang']['h1'] . '. ' .
                    Yii::t('app', 'Купить в') . ' ' .
                    Yii::$app->city->getCityTitleWhere()
                );
            } ?>

        </div>
        <a href="tel:<?= Yii::$app->partner->getPartnerPhone() ?>" class="tel">
            <?= Yii::$app->partner->getPartnerPhone() ?>
        </a>
        <nav class="nav">

            <?= Html::a(
                Yii::t('app', 'Main'),
                ['/catalog/factory/view', 'alias' => $this->context->factory['alias']]
            ) ?>

            <?= Html::a(
                Yii::t('app', 'Catalog of furniture'),
                ['/catalog/template-factory/catalog', 'alias' => $this->context->factory['alias']]
            ) ?>

            <?php
            if ($this->context->factory->getFactoryTotalCountSale()) {
                echo Html::a(
                    Yii::t('app', 'Sale'),
                    ['/catalog/template-factory/sale', 'alias' => $this->context->factory['alias']]
                );
            } ?>

            <?= Html::a(
                Yii::t('app', 'Каталоги'),
                ['/catalog/template-factory/catalogs-files', 'alias' => $this->context->factory['alias']]
            ) ?>

            <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->isPdfAccess() && !empty($this->context->factory->pricesFiles)) {
                echo Html::a(
                    Yii::t('app', 'Прайс листы'),
                    ['/catalog/template-factory/prices-files', 'alias' => $this->context->factory['alias']]
                );
            } ?>

            <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->showWorkingConditions()) {
                echo Html::a(
                    Yii::t('app', 'Условия работы'),
                    ['/catalog/template-factory/working-conditions', 'alias' => $this->context->factory['alias']]
                );
            } ?>

            <?= Html::a(
                Yii::t('app', 'Contacts'),
                ['/catalog/template-factory/contacts', 'alias' => $this->context->factory['alias']]
            ) ?>

        </nav>
    </div>
</div>

<?= $content ?>

<div class="top-footer">
    <div class="container large-container">

        <?php if (!in_array(Yii::$app->controller->action->id, ['sale', 'sale-product'])) {
            echo PartnerInfo::widget(['view' => 'template_factory_partner_info']);
        } ?>

        <div class="flex copy-r">
            <div>
                2013 - <?= date('Y'); ?> (с)
                <?= str_replace(['#городе#', '#nella citta#'], Yii::$app->city->getCityTitleWhere(), Yii::$app->param->getByName('FOOTER_COPYRIGHT_COM')); ?>
            </div>
            <div>
                <?php if (isset($this->context->factory['lang'])) {
                    echo $this->context->factory['lang']['h1'] . '. ' .
                        Yii::t('app', 'Купить в') . ' ' .
                        Yii::$app->city->getCityTitleWhere();
                } ?>
            </div>
        </div>
    </div>
</div>

<?= $this->render('parts/_jivosite', []) ?>
<?= $this->render('parts/_yandex_metrika', []) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
