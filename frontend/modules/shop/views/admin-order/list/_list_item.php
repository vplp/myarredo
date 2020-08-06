<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\shop\models\{
    Order, OrderItem
};
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
                            <td><?= Yii::t('app', 'Предмет') ?></td>
                            <td>
                                <?= Html::a(
                                    $orderItem->product['lang']['title'],
                                    Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()])
                                ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Артикул') ?></td>
                            <td>
                                <?= $orderItem->product['article'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Factory') ?></td>
                            <td>
                                <?= Html::a(
                                    $orderItem->product['factory']['title'],
                                    Factory::getUrl($orderItem->product['factory']['alias'])
                                ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Цена для клиента') ?></td>
                            <td>
                                <?php
                                foreach ($orderItem->orderItemPrices as $price) {
                                    echo '<div><strong>' . $price['user']['profile']['lang']['name_company'] . '</strong></div>' .
                                        '<div>' . $price['user']['email'] . '</div>' .
                                        '<div><strong>' . ($price['out_of_production'] == '1' ? Yii::t('app', 'Снят с производства') : $price['price']) . '</strong></div><br>';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>

                    <div class="downloads">
                        <?php
                        $pricesFiles = [];
                        if (isset($orderItem->product->factoryPricesFiles)) {
                            $pricesFiles = $orderItem->product->factoryPricesFiles;
                        } else if (isset($orderItem->product->factory->pricesFiles)) {
                            $pricesFiles = $orderItem->product->factory->pricesFiles;
                        }

                        if (!empty($pricesFiles)) { ?>
                            <p class="title-small"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
                            <ul class="pricelist">
                                <?php foreach ($pricesFiles as $priceFile) {
                                    if ($fileLink = $priceFile->getFileLink()) { ?>
                                        <li>
                                            <?= Html::a(
                                                $priceFile->title,
                                                Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink . '&search=' . $orderItem->product->article,
                                                [
                                                    'target' => '_blank',
                                                    'class' => 'click-on-factory-file',
                                                    'data-id' => $priceFile->id
                                                ]
                                            ) ?>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            <?php }
        } else {
            echo Yii::t('app', 'Клиент оставил данную заявку, так как не нашел то что искал на сайте.');
        }  ?>

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
            <?php
            echo Html::label($modelOrder->getAttributeLabel('comment')) .
                Html::textarea(
                    null,
                    $modelOrder->comment,
                    [
                        'class' => 'form-control',
                        'rows' => 5,
                        'disabled' => true
                    ]
                );

            if ($modelOrder->lang != 'ru-RU') {
                $form = ActiveForm::begin([
                    'id' => 'OrderAnswerForm',
                    'options' => ['data' => ['pjax' => true]],
                    'action' => Url::toRoute(['/shop/admin-order/update', 'id' => $modelOrder->id]),
                ]);

                echo $form
                        ->field($modelOrder, 'admin_comment')
                        ->textarea(['rows' => 5])

                    . Html::submitButton(
                        Yii::t('app', 'Save'),
                        [
                            'class' => 'btn btn-success',
                            'name' => 'action-save-admin-comment',
                            'value' => 1
                        ]
                    );

                ActiveForm::end();
            }

            foreach ($modelOrder->orderAnswers as $answer) {
                echo '<div><strong>' . $answer['user']['profile']['lang']['name_company'] . '</strong></div>' .
                    '<div>' . $answer['user']['email'] . '</div>' .
                    '<div>' . $answer->getAnswerTime() . '</div>' .
                    '<div>' . $answer['answer'] . '</div><br>';
            }
            ?>
        </div>

    </div>
</div>
