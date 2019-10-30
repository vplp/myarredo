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
                            <span>order_id</span>
                        </li>
                        <li>
                            <span>answer</span>
                        </li>
                        <li>
                            <span>products</span>
                        </li>
                        <li>
                            <span>answer_time</span>
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
                                    <span><?= $model->answer ?></span>
                                </li>
                                <li>
                                    <span>
                                        <?php
                                        $result = [];
                                        foreach ($model->order->items as $item) {
                                            $result[] = Html::a(
                                                $item->product->lang->title,
                                                $item->product::getUrl($item->product->alias),
                                                ['target' => '_blank']
                                            );
                                        }
                                        echo implode('<br>', $result);
                                        ?>
                                    </span>
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