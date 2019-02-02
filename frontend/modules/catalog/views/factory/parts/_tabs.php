<?php


use yii\helpers\{
    Url, Html
};
//
use frontend\modules\catalog\models\Factory;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 * @var \frontend\modules\catalog\models\FactoryCatalogsFiles $catalogFile
 * @var \frontend\modules\catalog\models\FactoryPricesFiles $priceFile
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

    <?php if (!empty($model->catalogsFiles)) { ?>
        <li>
            <a data-toggle="tab" href="#catalogs">
                <?= Yii::t('app', 'Каталоги') ?>
            </a>
        </li>
    <?php } ?>

    <?php if (!Yii::$app->getUser()->isGuest &&
        Yii::$app->user->identity->profile->isPdfAccess() &&
        !empty($model->pricesFiles)
    ) { ?>
        <li>
            <a data-toggle="tab" href="#pricelists">
                <?= Yii::t('app', 'Прайс листы') ?>
            </a>
        </li>
    <?php } ?>

    <?php
    if ($model->getFactoryTotalCountSale()) {
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

</ul>

<div class="tab-content">
    <div id="all-product" class="tab-pane fade in active">
        <ul class="list">
            <?php
            $FactoryTypes = Factory::getFactoryTypes($model['id']);

            foreach ($FactoryTypes as $item) {
                $params = Yii::$app->catalogFilter->params;

                $params[$keys['factory']][] = $model['alias'];
                $params[$keys['type']][] = $item['alias'];

                echo Html::beginTag('li') .
                    Html::a(
                        '<span class="for-allprod">'. $item['title']. '</span>' . ' <span>' . $item['count'] . '</span>',
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

                echo Html::beginTag('li') .
                    Html::a(
                        '<span class="for-allprod">' .$item['title']. '</span>' . ' <span>' . $item['count'] . '</span>',
                        Yii::$app->catalogFilter->createUrl($params)
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
                            ['target' => '_blank']
                        ) .
                        Html::endTag('li');
                } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (!Yii::$app->getUser()->isGuest &&
        Yii::$app->user->identity->profile->isPdfAccess() &&
        !empty($model->pricesFiles)
    ) { ?>
        <div id="pricelists" class="tab-pane fade">
            <ul class="list">
                <?php
                foreach ($model->pricesFiles as $priceFile) {
                    echo Html::beginTag('li') .
                        Html::a(
                            ($priceFile->image_link
                                ? Html::img($catalogFile->getImageLink())
                                : ''
                            ) .
                            Html::tag('span', $catalogFile->title, ['class' => 'for-catalog-list']),
                            $priceFile->getFileLink(),
                            ['target' => '_blank']
                        ) .
                        Html::endTag('li');
                } ?>
            </ul>
        </div>
    <?php } ?>

</div>
