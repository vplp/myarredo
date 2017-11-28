<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 * @var \frontend\modules\catalog\models\FactoryCatalogsFiles $catalogFile
 * @var \frontend\modules\catalog\models\FactoryPricesFiles $priceFile
 */

?>

<?php if (!Yii::$app->getUser()->isGuest && Yii::$app->getUser()->getIdentity()->group->role == 'admin'): ?>

    <div class="downloads">

        <?php if (!empty($model->catalogsFiles)): ?>
            <p class="title-small">Посмотреть каталоги</p>
            <ul>
                <?php foreach ($model->catalogsFiles as $catalogFile): ?>
                    <?php if ($fileLink = $catalogFile->getFileLink()): ?>
                        <li>
                            <?= Html::a($catalogFile->title, $fileLink, ['target' => '_blank']) ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($model->pricesFiles)): ?>
            <p class="title-small">Посмотреть прайс листы</p>
            <ul>
                <?php foreach ($model->pricesFiles as $priceFile): ?>
                    <?php if ($fileLink = $priceFile->getFileLink()): ?>
                        <li>
                            <?= Html::a($priceFile->title, $fileLink, ['target' => '_blank']) ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </div>

<?php endif; ?>
