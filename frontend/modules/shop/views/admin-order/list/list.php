<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
use frontend\modules\shop\models\Order;

/**
 * @var $pages Pagination
 * @var $modelOrder Order
 * @var $params array
 * @var $model array
 * @var $models array
 */

$this->title = $this->context->title;
?>

<main>
    <div class="page adding-product-page">
        <div class="largex-container">

            <?= Html::tag('h1', $this->context->title); ?>

            <?= $this->render('_form_filter', [
                'model' => $model,
                'params' => $params,
                'models' => $models,
            ]); ?>

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
                            <span><?= Yii::t('app', 'Country') ?></span>
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
                                        <?= ($modelOrder->country) ? $modelOrder->country->getTitle() : ''; ?>
                                    </span>
                                </li>
                                <li>
                                    <span>
                                        <?= ($modelOrder->city) ? $modelOrder->city->getTitle() : ''; ?>
                                    </span>
                                </li>
                                <li><span><?= $modelOrder->getOrderStatus(); ?></span></li>
                            </ul>

                            <div class="hidden-order-info flex">

                                <?= $this->render('_list_item', [
                                    'modelOrder' => $modelOrder,
                                ]) ?>

                            </div>
                        </div>

                    <?php } ?>

                </div>

                <?= frontend\components\LinkPager::widget([
                    'pagination' => $models->getPagination(),
                ]) ?>

            </div>
        </div>
    </div>
</main>
