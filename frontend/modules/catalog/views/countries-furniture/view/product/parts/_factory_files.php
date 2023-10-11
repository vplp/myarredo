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
            <p class="title-small"><?= Yii::t('app', 'Посмотреть каталоги') ?></p>
            <ul>
                <?php foreach ($model->factoryCatalogsFiles as $catalogFile): ?>
                    <?php if ($fileLink = $catalogFile->getFileLink()): ?>
                        <li>
                            <?= Html::a(
                                $catalogFile->getTitle(),
                                $fileLink,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file',
                                    'data-id' => $catalogFile->id
                                ]
                            ) ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($model->factoryPricesFiles)): ?>
            <p class="title-small"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
            <ul>
                <?php foreach ($model->factoryPricesFiles as $priceFile): ?>
                    <?php if ($fileLink = $priceFile->getFileLink()): ?>
                        <li>
                            <?= Html::a(
                                $priceFile->title,
                                $fileLink,
                                [
                                    'target' => '_blank',
                                    'class' => 'click-on-factory-file',
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
