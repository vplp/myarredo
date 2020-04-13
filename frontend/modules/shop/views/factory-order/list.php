<?php

use yii\helpers\{
    Html, Url
};
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
    <div class="page adding-product-page ordersbox">
        <div class="largex-container">

            <?= Html::tag('h1', $this->context->title); ?>

            <?= $this->render('/admin-order/list/_form_filter', [
                'model' => $model,
                'params' => $params,
                'models' => $models,
            ]); ?>

            <div class="manager-history">

                <?php if (!empty($models)) { ?>
                    <div class="manager-history-header">
                        <ul class="orders-title-block flex">
                            <li class="order-id">
                                <span>№</span>
                            </li>
                            <li class="application-date">
                                <span><?= Yii::t('app', 'Request Date') ?></span>
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

                        <?php foreach ($models->getModels() as $modelOrder) {
                            $is = false;
                            foreach ($modelOrder->items as $orderItem) {
                                if ($orderItem->product['factory_id'] == Yii::$app->user->identity->profile->factory_id) {
                                    $is = true;
                                    continue;
                                }
                            }
                            ?>
                            <div class="item" data-hash="<?= $modelOrder->id; ?>">
                                <ul class="orders-title-block flex" <?= $is ? 'style="background-color: #ecffe7;"' : ''; ?>>
                                    <li class="order-id">
                                        <span>
                                            <?= $modelOrder->id ?>
                                        </span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $modelOrder->getCreatedTime() ?></span>
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
                                    <?= $this->render('_list_item', [
                                        'modelOrder' => $modelOrder,
                                    ]) ?>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <?php } else { ?>
                    <div class="text-center">
                        <?= Yii::t(
                            'app',
                            'Пока что по мебели Вашей фабрики запросов не поступало.'
                        ) ?>
                    </div>
                <?php } ?>

            </div>

            <?= frontend\components\LinkPager::widget([
                'pagination' => $models->getPagination(),
            ]) ?>

        </div>
    </div>
</main>
