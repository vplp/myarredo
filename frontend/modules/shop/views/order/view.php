<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $product \frontend\modules\catalog\models\Product */
/* @var $item \frontend\modules\shop\models\CartItem */

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::tag('h2', $this->context->title) ?>
                </div>
                <div class="col-md-12">

                    <div class="flex basket-items">
                        <?php foreach ($order->items as $item) { ?>
                            <div class="basket-item-info">
                                <div class="item">
                                    <div class="img-cont">
                                        <?= Html::a(
                                            Html::img(Product::getImageThumb($item->product['image_link'])),
                                            Product::getUrl($item->product[Yii::$app->languages->getDomainAlias()])
                                        ) ?>
                                    </div>
                                    <table width="100%">
                                        <tr>
                                            <td><?= Yii::t('app', 'Предмет') ?></td>
                                            <td><?= $item->product['lang']['title'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= Yii::t('app', 'Factory') ?></td>
                                            <td><?= $item->product['factory']['title'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
