<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\shop\models\Order;
use frontend\modules\shop\models\OrderItem;
use frontend\modules\catalog\models\{
    Product, Factory
};

/* @var $this yii\web\View */
/* @var $modelOrder Order */
/* @var $orderItem OrderItem */

?>

<div class="hidden-order-in">
    <div class="flex-product">

        <?php if ($modelOrder->items) {
            foreach ($modelOrder->items as $orderItem) { ?>
                <div class="basket-item-info">
                    <div class="img-cont">
                        <?= Html::a(
                            Html::img(Product::getImageThumb($orderItem->product['image_link'])),
                            Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                            ['target' => '_blank']
                        ); ?>
                    </div>
                    <table class="char" width="100%">
                        <tr>
                            <td><?= Yii::t('app', 'Subject') ?></td>
                            <td>
                                <?= Html::a(
                                    $orderItem->product['lang']['title'],
                                    Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()])
                                ); ?>
                            </td>
                        </tr>

                        <?php if (isset($orderItem->product['is_composition']) && !$orderItem->product['is_composition']) { ?>
                            <tr>
                                <td><?= Yii::t('app', 'Артикул') ?></td>
                                <td>
                                    <?= $orderItem->product['article'] ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td><?= Yii::t('app', 'Factory') ?></td>
                            <td>
                                <?= Html::a(
                                    $orderItem->product['factory']['title'] ?? '',
                                    Factory::getUrl($orderItem->product['factory']['alias'])
                                ); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php }
        } else {
            echo Yii::t('app', 'Клиент оставил данную заявку, так как не нашел то что искал на сайте.');
        } ?>

        <?php if ($modelOrder->image_link) { ?>
            <div class="basket-item-info">
                <div class="img-cont">
                    <?= Html::img($modelOrder->getImageLink()); ?>
                </div>
            </div>
        <?php } ?>

    </div>
    <div class="form-wrap">
        <div class="form-group">

            <?php if ($modelOrder->orderAnswers) { ?>
                <div><?= Yii::t('app', 'Response time') ?>:</div>
                <?php foreach ($modelOrder->orderAnswers as $key => $answer) {
                    if ($answer->user->group->role == 'partner') {
                        echo '<div><strong>' . $answer['user']['profile']->getNameCompany() . '</strong></div>';
                    } elseif ($answer->user->group->role == 'factory') {
                        echo '<div><strong>' . $answer['user']['profile']['factory']['title'] . '</strong></div>';
                    }
                    echo '<div>' . ($key + 1) . ') ' . $answer->getAnswerTime() . '</div>';
                } ?>
            <?php } ?>
        </div>
    </div>
</div>
