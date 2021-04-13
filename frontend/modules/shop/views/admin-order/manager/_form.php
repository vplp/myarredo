<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
use frontend\modules\shop\models\Order;
use frontend\modules\catalog\models\{
    Product, Factory
};

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
                    </ul>
                </div>
                <div class="manager-history-list">
                    <div class="item">
                        <ul class="orders-title-block flex">
                            <li class="order-id">
                                <span><?= $modelOrder->id; ?></span>
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
                                <span><?= ($modelOrder->country) ? $modelOrder->country->getTitle() : ''; ?></span>
                            </li>
                            <li>
                                <span><?= ($modelOrder->city) ? $modelOrder->city->getTitle() : ''; ?></span>
                            </li>
                        </ul>

                        <div class="">

                            <div><?= Yii::t('shop', 'Товары заявки') ?>:</div>

                            <?php foreach ($modelOrder->items as $key => $orderItem) {
                                if (isset($orderItem->product)) {
                                    $str = '<div>';
                                    $str = $key + 1 . ')&nbsp;';


                                    $str .= Html::a(
                                        $orderItem->product->getTitle(),
                                        Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                                        ['target' => '_blank']
                                    );
                                    if ($orderItem->orderItemPrice->price) {
                                        $str .= '&nbsp;' . Yii::t('shop', 'Цена') . ':&nbsp;' . $orderItem->orderItemPrice->price . '&nbsp;' . $orderItem->orderItemPrice->currency;
                                    }
                                    $str .= '</div>';

                                    echo $str;
                                }
                            } ?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4">

                                    <?= Html::beginForm(['/shop/admin-order/manager', 'id' => $modelOrder->id], 'post', []) ?>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?= $modelOrder->getAttributeLabel('order_status') ?>:
                                        </label>
                                        <?= Html::dropDownList(
                                            'order_status',
                                            $modelOrder['order_status'],
                                            Order::getOrderStatuses(),
                                            [
                                                'id' => 'order_status',
                                                'class' => 'form-control',
                                            ]
                                        ); ?>
                                    </div>
                                    <div class="form-group">
                                        <?= Html::submitButton(Yii::t('app', 'Save'), [
                                            'class' => 'btn btn-primary',
                                        ]); ?>
                                    </div>
                                    <?= Html::endForm() ?>

                                    <?= Html::beginForm(['/shop/admin-order/manager', 'id' => $modelOrder->id], 'post', []) ?>
                                    <div class="form-group">
                                        <label class="control-label"><?= Yii::t('shop', 'Комментарий') ?>:</label>
                                        <?= Html::textarea(
                                            'comment',
                                            '',
                                            [
                                                'id' => 'comment',
                                                'class' => 'form-control',
                                            ]
                                        ); ?>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::submitButton(Yii::t('shop', 'Добавить комментарий'), [
                                            'class' => 'btn btn-primary',
                                        ]); ?>
                                    </div>
                                    <?= Html::endForm() ?>


                                    <?php foreach ($modelOrder->orderComments as $item) { ?>
                                        <div>
                                            <div><?= date('j.m.Y H:i', $item['updated_at']) ?></div>
                                            <div><?= $item['comment'] ?></div>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
