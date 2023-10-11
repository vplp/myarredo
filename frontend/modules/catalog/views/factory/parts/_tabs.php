<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\shop\models\Order;
use frontend\modules\catalog\models\{
    Product, Factory, FactoryCatalogsFiles, FactoryPricesFiles, Samples, CountriesFurniture, ItalianProduct
};
use frontend\modules\catalog\models\FactorySubdivision;

/**
 * @var $model Factory
 * @var $catalogFile FactoryCatalogsFiles
 * @var $priceFile FactoryPricesFiles
 * @var $samplesFile \frontend\modules\catalog\models\FactorySamplesFiles
 */

$keys = Yii::$app->catalogFilter->keys;

$route = $model->producing_country_id == 4
    ? ['/catalog/category/list']
    : ['/catalog/countries-furniture/list'];

$ItalianProductGrezzo = ItalianProduct::getGrezzo($model['id']);


?>

<ul class="nav nav-tabs">
    <li class="<?= Yii::$app->request->get('tab') == '' ? 'active' : ''; ?>">
        <?= Html::a(
            Yii::t('app', 'Все предметы мебели'),
            ['/catalog/factory/view', 'alias' => $model['alias']]
        ) ?>
    </li>
    <li class="<?= Yii::$app->request->get('tab') == 'collections' ? 'active' : ''; ?>">
        <?= Html::a(
            Yii::t('app', 'Все коллекции'),
            ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'collections']
        ) ?>
    </li>
    <li class="<?= Yii::$app->request->get('tab') == 'articles' ? 'active' : ''; ?>">
        <?= Html::a(
            Yii::t('app', 'Все артикулы'),
            ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'articles']
        ) ?>
    </li>

    <?php if (Factory::isShowCatalogsFiles($model) && !empty($model->catalogsFiles)) { ?>
        <li class="<?= Yii::$app->request->get('tab') == 'catalogs' ? 'active' : ''; ?>">
            <?= Html::a(
                Yii::t('app', 'Каталоги'),
                ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'catalogs']
            ) ?>
        </li>
    <?php } ?>

    <?php if (!empty($model->factorySubdivision) && !Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter'])) { ?>
        <li class="<?= Yii::$app->request->get('tab') == 'subdivision' ? 'active' : ''; ?>">
            <?= Html::a(
                Yii::t('app', 'Представительство'),
                ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'subdivision']
            ) ?>
        </li>
    <?php } ?>

    <li class="<?= Yii::$app->request->get('tab') == 'samples' ? 'active' : ''; ?>">
        <?= Html::a(
            Yii::t('app', 'Варианты отделки'),
            ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'samples']
        ) ?>
    </li>

    <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->isPdfAccess() && !empty($model->pricesFiles)) { ?>
        <li class="<?= Yii::$app->request->get('tab') == 'pricelists' ? 'active' : ''; ?>">
            <?= Html::a(
                Yii::t('app', 'Прайс листы'),
                ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'pricelists']
            ) ?>
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

    <?php if (!empty($ItalianProductGrezzo)) { ?>
        <li class="<?= Yii::$app->request->get('tab') == 'grezzo' ? 'active' : ''; ?>">
            <?= Html::a(
                Yii::t('app', 'Мебель со сроком производства от ... до ...'),
                ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'grezzo']
            ) ?>
        </li>
    <?php } ?>

    <?php if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter'])) { ?>
        <li class="<?= Yii::$app->request->get('tab') == 'orders' ? 'active' : ''; ?>">
            <?= Html::a(
                Yii::t('app', 'Orders'),
                ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'orders']
            ) ?>
        </li>
    <?php } ?>

    <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->showWorkingConditions()) { ?>
        <li class="<?= Yii::$app->request->get('tab') == 'working-conditions' ? 'active' : ''; ?>">
            <?= Html::a(
                Yii::t('app', 'Условия работы'),
                ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'working-conditions']
            ) ?>
        </li>
    <?php } ?>

    <?php /*if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter', 'partner'])) { ?>
        <li class="<?= Yii::$app->request->get('tab') == 'subdivision' ? 'active' : ''; ?>">
            <?= Html::a(
                Yii::t('app', 'Представительство'),
                ['/catalog/factory/view-tab', 'alias' => $model['alias'], 'tab' => 'subdivision']
            ) ?>
        </li>
    <?php }*/ ?>
</ul>

<div class="tab-content">
    <?php if (Yii::$app->request->get('tab') == '') { ?>
        <div id="all-product" class="tab-pane fade <?= Yii::$app->request->get('tab') == '' ? 'in active' : ''; ?>">
            <ul class="list">
                <?php
                $FactoryTypes = Factory::getFactoryTypes($model['id']);

                foreach ($FactoryTypes as $item) {
                    $params = Yii::$app->catalogFilter->params;

                    $params[$keys['factory']][] = $model['alias'];
                    $params[$keys['type']][] = $item[Yii::$app->languages->getDomainAlias()];
                    
                    echo Html::beginTag('li') .
                        Html::a(
                            '<span class="for-allprod">' . $item['title'] . '</span>' .
                            ' <span>' . $item['count'] . '</span>',
                            Yii::$app->catalogFilter->createUrl($params, $route)
                        ) .
                        Html::endTag('li');

                }
                ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (Yii::$app->request->get('tab') == 'collections') { ?>
        <div id="all-collection"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'collections' ? 'in active' : ''; ?>">
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
                            Yii::$app->catalogFilter->createUrl($params, $route)
                        ) .
                        Html::endTag('li');

                }
                ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (Yii::$app->request->get('tab') == 'articles') { ?>
        <div id="all-articles"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'articles' ? 'in active' : ''; ?>">
            <ul class="list">
                <?php
                $FactoryArticles = Factory::getFactoryArticles($model['id']);

                foreach ($FactoryArticles as $item) {
                    echo Html::beginTag('li') .
                        Html::a(
                            '<span class="for-allprod">' . $item['article'] . '</span>',
                            $model->producing_country_id == 4
                                ? Product::getUrl($item[Yii::$app->languages->getDomainAlias()])
                                : CountriesFurniture::getUrl($item['alias'])
                        ) .
                        Html::endTag('li');

                }
                ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (Factory::isShowCatalogsFiles($model) && Yii::$app->request->get('tab') == 'catalogs' && !empty($model->catalogsFiles)) { ?>
        <div id="catalogs"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'catalogs' ? 'in active' : ''; ?>">
            <ul class="list">
                <?php
                foreach ($model->catalogsFiles as $catalogFile) {
                    if ($fileLink = $catalogFile->getFileLink()) {
                        echo Html::beginTag('li') .
                            Html::a(
                                ($catalogFile->image_link
                                    ? Html::img($catalogFile->getImageLink())
                                    : ''
                                ) .
                                Html::tag('span', $catalogFile->getTitle(), ['class' => 'for-catalog-list']),
                                Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file',
                                    'data-id' => $catalogFile->id
                                ]
                            ) .
                            Html::endTag('li');
                    }
                } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (Yii::$app->request->get('tab') == 'subdivision' && !empty($model->factorySubdivision) && !Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter'])) { ?>
        <div id="subdivision"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'subdivision' ? 'in active' : ''; ?>">
            <ul class="list">
                <?php
                foreach ($model->factorySubdivision as $item) {
                    echo Html::beginTag('li') .
                        FactorySubdivision::getRegion($item['region']) . '<br>' .
                        $item->company_name . '<br>' .
                        $item->contact_person . '<br>' .
                        $item->email . '<br>' .
                        $item->phone . '<br>' .
                        Html::endTag('li');
                } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (Yii::$app->request->get('tab') == 'samples') { ?>
        <div id="all-samples"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'samples' ? 'in active' : ''; ?>">
            <ul class="list">
                <?php
                $FactorySamples = Factory::getFactorySamples($model['id']);

                foreach ($FactorySamples as $item) {
                    if (Samples::isImage($item['image_link'])) {
                        echo Html::beginTag('li') .
                            Html::a(
                                Html::img(Samples::getImageThumb($item['image_link']))
                                . Html::tag(
                                    'span',
                                    isset($item['lang']['title']) ? $item['lang']['title'] : '',
                                    ['class' => 'for-catalog-list']
                                ),
                                Samples::getImage($item['image_link']),
                                ['target' => '_blank']
                            ) .
                            Html::endTag('li');
                    }
                } ?>
            </ul>
        </div>

        <?php if(!empty($FactorySamples) && !empty($model->samplesFiles)) { ?>

            <style>
                #sample-files-lists {
                    border-top:1px solid #BDBCB3;
                }
            </style>

        <?php } ?>
            
        <div id="sample-files-lists"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'samples' ? 'in active' : ''; ?>">
            <ul class="list">
                <?php
                foreach ($model->samplesFiles as $samplesFile) {
                    if ($fileLink = $samplesFile->getFileLink()) {
                        echo Html::beginTag('li') .
                            Html::a(
                                ($samplesFile->image_link
                                    ? Html::img($samplesFile->getImageLink())
                                    : ''
                                ) .
                                Html::tag('span', $samplesFile->title . '<br>(' . date('d-m-Y', $samplesFile->updated_at) . ')', ['class' => 'for-catalog-list']),
                                Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file',
                                    'data-id' => $samplesFile->id
                                ]
                            ) .
                            Html::endTag('li');
                    }  
                } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (Yii::$app->request->get('tab') == 'pricelists' && !Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->isPdfAccess() && !empty($model->pricesFiles)) { ?>
        <div id="pricelists"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'pricelists' ? 'in active' : ''; ?>">
            <ul class="list">
                <?php
                foreach ($model->pricesFiles as $priceFile) {
                    if ($fileLink = $priceFile->getFileLink()) {
                        echo Html::beginTag('li') .
                            Html::a(
                                ($priceFile->image_link
                                    ? Html::img($priceFile->getImageLink())
                                    : ''
                                ) .
                                Html::tag('span', $priceFile->title . '<br>(' . date('d-m-Y', $priceFile->updated_at) . ')', ['class' => 'for-catalog-list']),
                                Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file',
                                    'data-id' => $priceFile->id
                                ]
                            ) .
                            Html::endTag('li');
                    }
                } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (Yii::$app->request->get('tab') == 'grezzo' && !empty($ItalianProductGrezzo)) { ?>
        <div id="all-grezzo"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'grezzo' ? 'in active' : ''; ?>">
            <ul class="list">
                <?php foreach ($ItalianProductGrezzo as $item) {
                    echo Html::beginTag('li') .
                        Html::a(
                            Html::tag('span', $item->getTitle(), ['class' => 'for-catalog-list']),
                            ItalianProduct::getUrl($item[Yii::$app->languages->getDomainAlias()]),
                            ['target' => '_blank']
                        ) .
                        Html::endTag('li');
                } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (Yii::$app->request->get('tab') == 'orders' && !Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter'])) { ?>
        <div id="orders" class="tab-pane fade <?= Yii::$app->request->get('tab') == 'orders' ? 'in active' : ''; ?>">
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
                                            <li><span><?= Order::getOrderStatuses($modelOrder->order_status); ?></span>
                                            </li>
                                        </ul>

                                        <div class="hidden-order-info flex">

                                            <?= $this->render('@app/modules/shop/views/admin-order/list/_list_item', [
                                                'modelOrder' => $modelOrder,
                                                'modelOrderAnswer' => $modelOrder->orderAnswer,
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

    <?php if (Yii::$app->request->get('tab') == 'working-conditions' && !Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->showWorkingConditions()) { ?>
        <div id="working-conditions"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'working-conditions' ? 'in active' : ''; ?>">

            <b><?= $model->getAttributeLabel('factory_discount') ?></b>: <?= $model->factory_discount ?><br>
            <?php if ($model->lang) { ?>
                <b><?= $model->lang->getAttributeLabel('wc_additional_discount_info') ?></b>: <?= $model->lang->wc_additional_discount_info ?>
                <br>
                <b><?= $model->getAttributeLabel('factory_discount_with_exposure') ?></b>: <?= $model->factory_discount_with_exposure ?>
                <br>
                <b><?= $model->getAttributeLabel('factory_discount_on_exposure') ?></b>: <?= $model->factory_discount_on_exposure ?>
                <br>
                <b><?= $model->lang->getAttributeLabel('wc_additional_cost_calculations_info') ?></b>: <?= $model->lang->wc_additional_cost_calculations_info ?>
                <br>
                <b><?= $model->lang->getAttributeLabel('wc_expiration_date') ?></b>: <?= $model->lang->wc_expiration_date ?>
                <br>
                <b><?= $model->lang->getAttributeLabel('wc_terms_of_payment') ?></b>: <?= $model->lang->wc_terms_of_payment ?>
                <br>

                <?php if (in_array(DOMAIN_TYPE, ['ru', 'ua', 'by'])) { ?>
                    <b><?= $model->lang->getAttributeLabel('wc_phone_supplier') ?></b>: <?= $model->lang->wc_phone_supplier ?>
                    <br>
                    <b><?= $model->lang->getAttributeLabel('wc_email_supplier') ?></b>: <?= $model->lang->wc_email_supplier ?>
                    <br>
                    <b><?= $model->lang->getAttributeLabel('wc_contact_person_supplier') ?></b>: <?= $model->lang->wc_contact_person_supplier ?>
                    <br>
                <?php } else { ?>
                    <b><?= $model->lang->getAttributeLabel('wc_phone_factory') ?></b>: <?= $model->lang->wc_phone_factory ?>
                    <br>
                    <b><?= $model->lang->getAttributeLabel('wc_email_factory') ?></b>: <?= $model->lang->wc_email_factory ?>
                    <br>
                    <b><?= $model->lang->getAttributeLabel('wc_contact_person_factory') ?></b>: <?= $model->lang->wc_contact_person_factory ?>
                    <br>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>

    <?php /*if (Yii::$app->request->get('tab') == 'subdivision' && !Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter', 'partner'])) { ?>
        <div id="working-conditions"
             class="tab-pane fade <?= Yii::$app->request->get('tab') == 'subdivision' ? 'in active' : ''; ?>">
            <?= $model->lang->subdivision ?>
        </div>
    <?php }*/ ?>
</div>
