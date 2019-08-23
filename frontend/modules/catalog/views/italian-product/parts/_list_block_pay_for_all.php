<?php

use yii\helpers\{ArrayHelper, Html, Url};
use yii\data\Pagination;
use yii\widgets\Pjax;
use kartik\grid\GridView;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    ItalianProduct, Factory
};
use backend\app\bootstrap\ActiveForm;

/**
 * @var $pages Pagination
 * @var $model ItalianProduct
 * @var $filter ItalianProduct
 */

$paidCount = $freeCount = $paidCost = $freeCost = 0;
foreach ($dataProvider->getModels() as $model) {
    if ($model->create_mode == 'paid') {
        ++$paidCount;
        $paidCost = $paidCost + ItalianProduct::getCostPlacementProduct()['amount'];
    } elseif ($model->create_mode == 'free') {
        ++$freeCount;
        $freeCost = $freeCost + ItalianProduct::getFreeCostPlacementProduct($model)['amount'];
    }
} ?>

    <p>
        <?= Yii::t(
            'app',
            'Размещено товаров: {paidCount} платно - {paidCost}, {freeCount} бесплатно ({percentages}% - {freeCost})',
            [
                'paidCount' => $paidCount,
                'paidCost' => $paidCost . ' RUB',
                'percentages' => 22,
                'freeCount' => $freeCount,
                'freeCost' => $freeCost . ' RUB'
            ]
        ); ?>
    </p>

<?php
$paidCount = $freeCount = $count = 0;
foreach ($dataProvider->getModels() as $model) {
    if ($model->create_mode == 'paid' && $model->published == 0) {
        ++$paidCount;
    } elseif ($model->create_mode == 'free' && $model->published == 0) {
        ++$freeCount;
    }
}
$count = $paidCount + $freeCount;
if ($count) {
    $modelCostProduct = ItalianProduct::getCostPlacementProduct($paidCount + $freeCount);
    ?>
    <div class="total-box">
        <div>
            <span class="for-total">Кол. товаров платно:</span> <span class="for-styles"><?= $paidCount ?></span>
        </div>
        <div>
            <span class="for-total">Кол. товаров бесплатно:</span> <span class="for-styles"><?= $freeCount ?></span>
        </div>
        <div>
            <span class="for-total"><?= Yii::t('app', 'Итого') ?>:</span> <span
                    class="for-styles"><?= $modelCostProduct['total'] . ' ' . $modelCostProduct['currency'] ?></span>
        </div>
        <div>
            <span class="for-total"><?= Yii::t('app', 'В том числе НДС') ?> :</span> <span
                    class="for-styles"><?= $modelCostProduct['nds'] . ' ' . $modelCostProduct['currency'] ?></span>
        </div>
        <div>
            <span class="for-total"><?= Yii::t('app', 'Скидка') . ' ' . $modelCostProduct['discount_percent'] . '%'; ?> :</span>
            <span class="for-styles"><?= $modelCostProduct['discount_money'] . ' ' . $modelCostProduct['currency'] ?></span>
        </div>
        <div>
            <span class="for-total"><?= Yii::t('app', 'Всего к оплате') ?> :</span> <span
                    class="for-styles"><?= $modelCostProduct['amount'] . ' ' . $modelCostProduct['currency'] ?></span>
        </div>
    </div>

    <?php
    echo '<form action="' . Url::toRoute(['/catalog/italian-product/payment'], true) . '" method="get">';

    foreach ($dataProvider->getModels() as $model) {
        if ($model->published == 0) {
            echo '<input type="hidden" name="id[]" value="' . $model['id'] . '">';
        }
    }

    echo Html::submitButton(
        Yii::t('app', 'Оплатить все товары по платному тарифу'),
        ['class' => 'btn btn-success']
    );

    echo '</form>';
}
