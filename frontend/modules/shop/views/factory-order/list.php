<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\shop\models\Order $modelOrder
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?= Html::tag('h1', $this->context->title); ?>

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
                            <li>
                                <span><?= Yii::t('app', 'City') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'Status') ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="manager-history-list">

                        <?php foreach ($models as $modelOrder) { ?>
                            <div class="item" data-hash="<?= $modelOrder->id; ?>">
                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span>
                                            <?= $modelOrder->id ?>
                                        </span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $modelOrder->getCreatedTime() ?></span>
                                    </li>
                                    <li><span>
                                            <?= ($modelOrder->city) ? $modelOrder->city->lang->title : ''; ?>
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
                'pagination' => $pages,
            ]) ?>

        </div>
    </div>
</main>