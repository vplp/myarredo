<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    FactoryCatalogsFiles, Product, Factory, FactoryPricesFiles
};

/**
 * @var Product $model
 * @var FactoryCatalogsFiles $catalogFile
 * @var FactoryPricesFiles $priceFile
 */

?>

<div class="downloads">
    <?php if ($model->factory && Factory::isShowCatalogsFiles($model->factory)) { ?>
        <p class="inpdf-title"><?= Yii::t('app', 'Посмотреть каталоги') ?></p>
        <ul class="inpdf-list">
            <?php if (!empty($model->factoryCatalogsFiles)) { ?>
                <?php foreach ($model->factoryCatalogsFiles as $catalogFile) {
                    if ($fileLink = FactoryCatalogsFiles::getFileLink($catalogFile)) { ?>
                        <li>
                            <?= Html::a(
                                $catalogFile->getTitle() . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                                Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink . '&search=' . $model->article,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file btn-inpdf',
                                    'data-id' => $catalogFile->id
                                ]
                            ) ?>
                        </li>
                    <?php }
                } ?>
            <?php } else { ?>
                <li>
                    <?= Html::a(
                        Yii::t('app', 'Каталоги') . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                        ['/catalog/factory/view-tab', 'alias' => $model->factory->alias, 'tab' => 'catalogs'],
                        [
                            'target' => '_blank',
                            'class' => 'btn-inpdf'
                        ]
                    ) ?>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

    <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->isPdfAccess()) { ?>
        <p class="inpdf-title"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
        <ul class="inpdf-list">
            <?php if (!empty($model->factoryPricesFiles)) {
                foreach ($model->factoryPricesFiles as $priceFile) {
                    if ($fileLink = FactoryPricesFiles::getFileLink($priceFile)) { ?>
                        <li>
                            <?= Html::a(
                                $priceFile->title . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                                Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink . '&search=' . $model->article,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file btn-inpdf',
                                    'data-id' => $priceFile->id
                                ]
                            ) ?>
                        </li>
                    <?php }
                }
            } elseif ($model->is_composition) {
                $isFiles = false;
                foreach ($model->getElementsComposition() as $product) {
                    /** @var $product Product */
                    foreach ($product->factoryPricesFiles as $priceFile) {
                        if ($fileLink = FactoryPricesFiles::getFileLink($priceFile)) {
                            $isFiles = true;
                            ?>
                            <li>
                                <?= Html::a(
                                    $product->getTitle() . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                                    Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink . '&search=' . $product->article,
                                    [
                                        'target' => '_blank',
                                        'class' => 'click-on-factory-file btn-inpdf',
                                        'data-id' => $priceFile->id
                                    ]
                                ) ?>
                            </li>
                        <?php }
                    }
                }

                if (!$isFiles) { ?>
                    <li>
                        <?= Html::a(
                            Yii::t('app', 'Прайс листы') . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                            ['/catalog/factory/view-tab', 'alias' => $model->factory->alias, 'tab' => 'pricelists'],
                            [
                                'target' => '_blank',
                                'class' => 'btn-inpdf'
                            ]
                        ) ?>
                    </li>
                <?php }
            } else { ?>
                <li>
                    <?= Html::a(
                        Yii::t('app', 'Прайс листы') . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                        ['/catalog/factory/view-tab', 'alias' => $model->factory->alias, 'tab' => 'pricelists'],
                        [
                            'target' => '_blank',
                            'class' => 'btn-inpdf'
                        ]
                    ) ?>
                </li>
                <?php
            } ?>
        </ul>

    <?php } ?>
</div>

