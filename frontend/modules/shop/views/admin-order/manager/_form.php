<?php

use yii\helpers\{
    Html, Url
};
use kartik\date\DatePicker;
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
                    <div class="item" style="border-bottom: none;">
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
                                <span>
                                    <?php  if ((Yii::$app->user->identity->id == 3388061 && $modelOrder->orderAnswer->answer_time == 0) || !Yii::$app->user->identity->profile->getPossibilityToViewCustomer($modelOrder)) {
                                       echo '-';
                                   } else {
                                       echo $modelOrder->customer->phone;
                                   } ?>
                               </span>
                            </li>
                            <li>
                                <span>
                                 <?php if ((Yii::$app->user->identity->id == 3388061 && $modelOrder->orderAnswer->answer_time == 0) || !Yii::$app->user->identity->profile->getPossibilityToViewCustomer($modelOrder)) {
                                     echo '-';
                                 } else {
                                     echo $modelOrder->customer->email;
                                 } ?>
                                </span>
                            </li>
                            <li class="lang-cell">
                                <span><?= substr($modelOrder->lang, 0, 2) ?></span>
                            </li>
                            <li>
                                <span><?= ($modelOrder->country) ? $modelOrder->country->getTitle() : ''; ?></span>
                            </li>
                            <li>
                                <span><?= $modelOrder->city_name ?? ($modelOrder->city ? $modelOrder->city->getTitle() : ''); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="container large-container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div><?= Yii::t('app', 'Товары заявки') ?>:</div>

                        <?php foreach ($modelOrder->items as $key => $orderItem) {
                            if (isset($orderItem->product)) {
                                $str = $key + 1 . ')&nbsp;';

                                $str .= Html::img(Product::getImageThumb($orderItem->product['image_link']), ['width' => 50]);

                                $str .= Html::a(
                                    $orderItem->product->getTitle(),
                                    Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                                    ['target' => '_blank']
                                );
                                if ($orderItem->orderItemPrice->price) {
                                    $str .= '&nbsp;' . Yii::t('app', 'Цена') . ':&nbsp;' . $orderItem->orderItemPrice->price . '&nbsp;' . $orderItem->orderItemPrice->currency;
                                }

                                $arrPrices = [];
                                foreach ($orderItem->orderItemPrices as $price) {
                                    if ($price->user_id != Yii::$app->user->id  && Yii::$app->user->identity->group->role != 'admin') continue;
                                    $arrPrices[] = $price['user']['profile']->getNameCompany() . '&nbsp;' . ($price['out_of_production'] == '1'
                                            ? Yii::t('app', 'Снят с производства')
                                            : $price['price'] . ' ' . $price['currency']);
                                }

                                if ($arrPrices) {
                                    $str .= Html::tag('div', '(' . implode(', ', $arrPrices) . ')');
                                }

                                echo Html::tag('div', $str);
                            }
                        } ?>

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

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#comment" aria-controls="comment" role="tab"
                                   data-toggle="tab"><?= Yii::t('app', 'Добавить комментарий') ?></a>
                            </li>
                            <li role="presentation">
                                <a href="#reminder" aria-controls="reminder" role="tab"
                                   data-toggle="tab"><?= Yii::t('app', 'Добавить напоминание') ?></a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <!-- comment -->
                            <div role="tabpanel" class="tab-pane active" id="comment">
                                <?= Html::beginForm(['/shop/admin-order/manager', 'id' => $modelOrder->id], 'post', []) ?>
                                <?= Html::hiddenInput('type', 'comment') ?>
                                <div class="form-group">
                                    <label class="control-label"><?= Yii::t('app', 'Комментарий') ?>:</label>
                                    <?= Html::textarea(
                                        'content',
                                        '',
                                        ['class' => 'form-control']
                                    ); ?>
                                </div>
                                <div class="form-group">
                                    <?= Html::submitButton(Yii::t('app', 'Добавить комментарий'), [
                                        'class' => 'btn btn-primary',
                                    ]); ?>
                                </div>
                                <?= Html::endForm() ?>
                            </div>

                            <!-- reminder -->
                            <div role="tabpanel" class="tab-pane" id="reminder">
                                <?= Html::beginForm(['/shop/admin-order/manager', 'id' => $modelOrder->id], 'post', []) ?>
                                <?= Html::hiddenInput('type', 'reminder') ?>

                                <div class="form-group">
                                    <label class="control-label"><?= Yii::t('app', 'Дата') ?>:</label>
                                    <?= DatePicker::widget([
                                        'name' => 'reminder_time',
                                        'value' => date('j.m.Y'),
                                        'options' => ['placeholder' => ''],
                                        'pluginOptions' => [
                                            'format' => 'dd.m.yyyy',
                                            'todayHighlight' => true
                                        ]
                                    ]); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= Yii::t('app', 'Напоминание') ?>:</label>
                                    <?= Html::textarea(
                                        'content',
                                        '',
                                        ['class' => 'form-control']
                                    ); ?>
                                </div>
                                <div class="form-group">
                                    <?= Html::submitButton(Yii::t('app', 'Добавить напоминание'), [
                                        'class' => 'btn btn-primary',
                                    ]); ?>
                                </div>
                                <?= Html::endForm() ?>
                            </div>
                        </div>

                        <!-- list -->
                        <?php foreach ($modelOrder->orderComments as $item) { ?>
                            <?php if ($item->user_id != Yii::$app->user->id && Yii::$app->user->identity->group->role != 'admin') continue;?>
                            <div>
                                <div><?= date('j.m.Y H:i', $item['updated_at']) ?></div>
                                <?php if ($item['type'] == 'reminder') { ?>
                                    <div style="border: 1px solid red;"><?= date('j.m.Y', $item['reminder_time']) ?> <?= $item['content'] ?></div>
                                <?php } else { ?>
                                    <div><?= $item['content'] ?></div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <!-- buttons -->
                        <br>
                        <?= Html::a(
                            Yii::t('app', 'Вернуться к заявкам'),
                            ['/shop/admin-order/list'],
                            ['class' => 'btn btn-cancel']
                        ) ?>

                        <?= Html::a(
                            Yii::t('app', 'Все заявки этого клиента'),
                            Url::toRoute(['/shop/admin-order/list']) . '?email=' . $modelOrder->customer->email,
                            ['class' => 'btn btn-cancel']
                        ) ?>
                        <br>
                        <br>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
