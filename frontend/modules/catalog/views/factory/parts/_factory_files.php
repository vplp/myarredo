<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 * @var \frontend\modules\catalog\models\FactoryCatalogsFiles $catalogFile
 * @var \frontend\modules\catalog\models\FactoryPricesFiles $priceFile
 */

?>

<?php if (
    !Yii::$app->getUser()->isGuest &&
    Yii::$app->user->identity->profile->isPdfAccess()
): ?>

    <div class="downloads">

        <?php if (!empty($model->catalogsFiles)): ?>
            <p class="title-small">Посмотреть каталоги</p>
            <ul>

                <?php
                foreach ($model->catalogsFiles as $catalogFile) {
                    if ($fileLink = $catalogFile->getFileLink()) {
                        echo Html::beginTag('li') .
                            Html::a($catalogFile->title, $fileLink, ['target' => '_blank']) .
                            Html::endTag('li');
                    }
                } ?>

            </ul>
        <?php endif; ?>

        <?php if (!empty($model->pricesFiles)): ?>
            <p class="title-small">Посмотреть прайс листы</p>
            <ul>

                <?php
                foreach ($model->pricesFiles as $priceFile) {
                    if ($fileLink = $priceFile->getFileLink()) {
                        echo Html::beginTag('li') .
                            Html::a($priceFile->title, $fileLink, ['target' => '_blank']) .
                            Html::endTag('li');
                    }
                } ?>

            </ul>
        <?php endif; ?>

    </div>

<?php endif; ?>
