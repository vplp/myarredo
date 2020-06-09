<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Product $model
 * @var \frontend\modules\catalog\models\FactoryCatalogsFiles $catalogFile
 * @var \frontend\modules\catalog\models\FactoryPricesFiles $priceFile
 */

?>

<?php if (
    !Yii::$app->getUser()->isGuest &&
    Yii::$app->user->identity->profile->isPdfAccess()
): ?>

    <div class="downloads">

        <?php if (!empty($model->factoryCatalogsFiles)): ?>
            <p class="inpdf-title"><?= Yii::t('app', 'Посмотреть каталоги') ?></p>
            <ul class="inpdf-list">
                
                <?php foreach ($model->factoryCatalogsFiles as $catalogFile): ?>
                    <?php if ($fileLink = $catalogFile->getFileLink()): ?>
                        <li>
                            <?= Html::a(
                                $catalogFile->title . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                                'inpdf/web/viewer.html?file=/inpdf/test.pdf',
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file btn-inpdf',
                                    'data-id' => $catalogFile->id,
                                    'title' => 'Улучшеный просмотр PDF'
                                ]
                            ) ?>
                            <?= Html::a(
                                '<i class="fa fa-file" aria-hidden="true"></i>',
                                $fileLink,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file btn-inpdf',
                                    'data-id' => $catalogFile->id,
                                    'title' => 'Обычный просмотр PDF'
                                ]
                            ) ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($model->factoryPricesFiles)): ?>
            <p class="inpdf-title"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
            <ul class="inpdf-list">
                <?php foreach ($model->factoryPricesFiles as $priceFile): ?>
                    <?php if ($fileLink = $priceFile->getFileLink()): ?>
                        <li>
                            <?= Html::a(
                                $priceFile->title,
                                $fileLink,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file btn-inpdf',
                                    'data-id' => $priceFile->id
                                ]
                            ) ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </div>

<?php endif; ?>
