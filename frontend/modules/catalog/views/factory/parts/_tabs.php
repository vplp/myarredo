<?php

use yii\helpers\{
    Url, Html
};
//
use frontend\modules\shop\models\Order;
use frontend\modules\catalog\models\{
    Product, Factory, FactoryCatalogsFiles, FactoryPricesFiles, Samples
};

/**
 * @var $model Factory
 * @var $catalogFile FactoryCatalogsFiles
 * @var $priceFile FactoryPricesFiles
 */

$keys = Yii::$app->catalogFilter->keys;

?>

<ul class="nav nav-tabs">
    <li class="active">
        <a data-toggle="tab" href="#all-product">
            <?= Yii::t('app', 'Все предметы мебели') ?>
        </a>
    </li>
    <li>
        <a data-toggle="tab" href="#all-collection">
            <?= Yii::t('app', 'Все коллекции') ?>
        </a>
    </li>
    <li>
        <a data-toggle="tab" href="#all-articles">
            <?= Yii::t('app', 'Все артикулы') ?>
        </a>
    </li>

    <?php if (!empty($model->catalogsFiles)) { ?>
        <li>
            <a data-toggle="tab" href="#catalogs">
                <?= Yii::t('app', 'Каталоги') ?>
            </a>
        </li>
    <?php } ?>

    <li>
        <a data-toggle="tab" href="#all-samples">
            <?= Yii::t('app', 'Варианты отделки') ?>
        </a>
    </li>

    <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->isPdfAccess() && !empty($model->pricesFiles)) { ?>
        <li>
            <a data-toggle="tab" href="#pricelists">
                <?= Yii::t('app', 'Прайс листы') ?>
            </a>
        </li>
    <?php } ?>

    <?php if ($model->getFactoryTotalCountSale()) {
        echo Html::tag(
            'li',
            Html::a(
                Yii::t('app', 'Sale'),
                Yii::$app->catalogFilter->createUrl(
                    Yii::$app->catalogFilter->params +
                    [$keys['factory'] => $model['alias']],
                    '/catalog/sale/list'
                ),
                ['class' => 'view-all']
            )
        );
    } ?>

    <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'admin') { ?>
        <li>
            <a data-toggle="tab" href="#orders">
                <?= Yii::t('app', 'Orders') ?>
            </a>
        </li>
    <?php } ?>
</ul>

<div class="tab-content">
    <div id="all-product" class="tab-pane fade in active">
        <ul class="list">
            <?php
            $FactoryTypes = Factory::getFactoryTypes($model['id']);

            foreach ($FactoryTypes as $item) {
                $params = Yii::$app->catalogFilter->params;

                $params[$keys['factory']][] = $model['alias'];
                $params[$keys['type']][] = Yii::$app->city->domain != 'com' ? $item['alias'] : $item['alias2'];

                echo Html::beginTag('li') .
                    Html::a(
                        '<span class="for-allprod">' . $item['title'] . '</span>' .
                        ' <span>' . $item['count'] . '</span>',
                        Yii::$app->catalogFilter->createUrl($params)
                    ) .
                    Html::endTag('li');

            }
            ?>
        </ul>
    </div>

    <div id="all-collection" class="tab-pane fade">
        <ul class="list">
            <?php
            $FactoryCollection = Factory::getFactoryCollection($model['id']);

            foreach ($FactoryCollection as $item) {
                $params = Yii::$app->catalogFilter->params;

                $params[$keys['factory']][] = $model['alias'];
                $params[$keys['collection']][] = $item['id'];

                $title = $item['title'] . ($item['year'] > 0 ? ' (' . $item['year'] . ')' : '');

                echo Html::beginTag('li') .
                    Html::a(
                        '<span class="for-allprod">' . $title . '</span>' .
                        ' <span>' . $item['count'] . '</span>',
                        Yii::$app->catalogFilter->createUrl($params)
                    ) .
                    Html::endTag('li');

            }
            ?>
        </ul>
    </div>

    <div id="all-articles" class="tab-pane fade">
        <ul class="list">
            <?php
            $FactoryArticles = Factory::getFactoryArticles($model['id']);

            foreach ($FactoryArticles as $item) {
                echo Html::beginTag('li') .
                    Html::a(
                        '<span class="for-allprod">' . $item['article'] . '</span>',
                        Product::getUrl($item['alias'])
                    ) .
                    Html::endTag('li');

            }
            ?>
        </ul>
    </div>

    <?php if (!empty($model->catalogsFiles)) { ?>
        <div id="catalogs" class="tab-pane fade">
            <ul class="list">
                <?php
                foreach ($model->catalogsFiles as $catalogFile) {
                    echo Html::beginTag('li') .
                        Html::a(
                            ($catalogFile->image_link
                                ? Html::img($catalogFile->getImageLink())
                                : ''
                            ) .
                            Html::tag('span', $catalogFile->title, ['class' => 'for-catalog-list']),
                            $catalogFile->getFileLink(),
                            ['target' => '_blank', 'class' => 'click-by-factory-file', 'data-id' => $catalogFile->id]
                        ) .
                        Html::endTag('li');
                } ?>
            </ul>
        </div>
    <?php } ?>


    <div id="all-samples" class="tab-pane fade">
        <ul class="list">
            <?php
            $FactorySamples = Factory::getFactorySamples($model['id']);

            foreach ($FactorySamples as $item) {
                echo Html::beginTag('li') .
                    Html::a(
                        Html::img(Samples::getImage($model['image_link'])),
                        Samples::getImage($model['image_link'])
                    ) .
                    Html::endTag('li');
            }
            ?>
        </ul>
    </div>

    <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->isPdfAccess() && !empty($model->pricesFiles)) { ?>
        <div id="pricelists" class="tab-pane fade">
            <ul class="list">
                <?php
                foreach ($model->pricesFiles as $priceFile) {
                    echo Html::beginTag('li') .
                        Html::a(
                            ($priceFile->image_link
                                ? Html::img($priceFile->getImageLink())
                                : ''
                            ) .
                            Html::tag('span', $priceFile->title, ['class' => 'for-catalog-list']),
                            $priceFile->getFileLink(),
                            ['target' => '_blank', 'class' => 'click-by-factory-file', 'data-id' => $priceFile->id]
                        ) .
                        Html::endTag('li');
                } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'admin') { ?>
        <div id="orders" class="tab-pane fade">
            <?php
            $modelOrder = new Order();
            /** @var $modelOrder Order */
            $params['product_type'] = 'product';
            $params['factory_id'] = $model['id'];
            $params['defaultPageSize'] = 50;

            $models = $modelOrder->search($params);
            ?>
            <main>
                <div class="page adding-product-page">
                    <div class="largex-container">
                        <div class="manager-history">
                            <div class="manager-history-header">
                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span>№</span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= Yii::t('app', 'Request Date') ?></span>
                                    </li>
                                    <li>
                                        <span><?= Yii::t('app', 'Name') ?></span>
                                    </li>
                                    <li>
                                        <span><?= Yii::t('app', 'Phone') ?></span>
                                    </li>
                                    <li>
                                        <span><?= Yii::t('app', 'Email') ?></span>
                                    </li>
                                    <li class="lang-cell">
                                        <span><?= Yii::t('app', 'lang') ?></span>
                                    </li>
                                    <li>
                                        <span><?= Yii::t('app', 'City') ?></span>
                                    </li>
                                    <li>
                                        <span><?= Yii::t('app', 'Status') ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="manager-history-list">

                                <?php foreach ($models->getModels() as $modelOrder) { ?>
                                    <div class="item" data-hash="<?= $modelOrder->id; ?>">

                                        <ul class="orders-title-block flex">
                                            <li class="order-id">
                                    <span>
                                        <?= $modelOrder->id; ?>
                                    </span>
                                            </li>
                                            <li class="application-date">
                                                <span><?= $modelOrder->getCreatedTime() ?></span>
                                            </li>
                                            <li>
                                                <span><?= $modelOrder->customer->full_name ?></span>
                                            </li>
                                            <li>
                                                <span><?= $modelOrder->customer->phone ?></span>
                                            </li>
                                            <li>
                                                <span><?= $modelOrder->customer->email ?></span>
                                            </li>
                                            <li class="lang-cell">
                                                <span><?= substr($modelOrder->lang, 0, 2) ?></span>
                                            </li>
                                            <li>
                                                <span>
                                                    <?= ($modelOrder->city) ? $modelOrder->city->getTitle() : ''; ?>
                                                </span>
                                            </li>
                                            <li><span><?= $modelOrder->getOrderStatus(); ?></span></li>
                                        </ul>

                                        <div class="hidden-order-info flex">

                                            <?= $this->render('@app/modules/shop/views/admin-order/list/_list_item', [
                                                'modelOrder' => $modelOrder,
                                            ]) ?>

                                        </div>
                                    </div>

                                <?php } ?>

                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    <?php } ?>

</div>
