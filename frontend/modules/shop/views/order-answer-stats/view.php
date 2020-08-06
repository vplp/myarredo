<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\shop\models\{
    OrderAnswer, OrderItemPrice
};

/**
 * @var $pages \yii\data\Pagination
 * @var $models OrderAnswer[]
 * @var $model OrderAnswer
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
                            <span><?= Yii::t('app', 'Order id') ?></span>
                        </li>
                        <li>
                            <span><?= Yii::t('app', 'City') ?></span>
                        </li>
                        <li>
                            <span><?= Yii::t('app', 'Answer') ?></span>
                        </li>
                        <li>
                            <span><?= Yii::t('app', 'Products') ?></span>
                        </li>
                        <li>
                            <span><?= Yii::t('app', 'Answer time') ?></span>
                        </li>
                    </ul>
                </div>
                <div class="manager-history-list">

                    <?php foreach ($models->getModels() as $model) { ?>
                        <div class="item">
                            <ul class="orders-title-block flex">
                                <li class="order-id">
                                    <span><?= $model->order_id ?></span>
                                </li>
                                <li>
                                    <span><?= $model->order->city->getTitle() ?></span>
                                </li>
                                <li>
                                    <span><?= $model->answer ?></span>
                                </li>
                                <li>
                                    <table>
                                        <?php
                                        $result = [];
                                        foreach ($model->order->items as $item) {
                                            echo Html::tag(
                                                'tr',
                                                Html::tag(
                                                    'td',
                                                    Html::a(
                                                        $item->product->lang->title,
                                                        $item->product::getUrl($item->product[Yii::$app->languages->getDomainAlias()]),
                                                        ['target' => '_blank']
                                                    )
                                                ) . Html::tag(
                                                    'td',
                                                    $item->price
                                                )
                                            );
                                        }
                                        ?>
                                    </table>
                                </li>
                                <li>
                                    <span><?= date('d-m-Y', $model->answer_time) ?></span>
                                </li>
                            </ul>
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
