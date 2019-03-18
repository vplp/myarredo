<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\ItalianProduct;

$this->title = $this->context->title;


?>

<main>
    <div class="page create-sale page-reclamations">
        <div class="largex-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="column-center">
                <div class="form-horizontal">

                    <div>
                        <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_PAYMENT_TEXT') ?>
                    </div>

                    <div id="list-product">
                        <?php
                        foreach ($models as $product) {
                            echo '<div class="list-product-item">' .
                                $product->lang->title .
                                Html::input(
                                    'hidden',
                                    'FactoryPromotion[product_ids][]',
                                    $product->id
                                ) .
                                Html::img(ItalianProduct::getImageThumb($product['image_link']), ['width' => 50]) .
                                Html::a(
                                    '<i class="fa fa-times"></i></a>',
                                    "javascript:void(0);",
                                    [
                                        'id' => 'del-product',
                                        'class' => 'close',
                                        'data-id' => $product->id
                                    ]
                                ) .
                                '</div>';
                        } ?>
                    </div>

                    <div>Всего к оплате <?= count($models) * 5 ?> евро</div>

                    <?= Html::button(
                        Yii::t('app', 'Перейти к оплате'),
                        ['class' => 'btn btn-goods', 'name' => 'payment', 'value' => 1]
                    ) ?>

                    <?= Html::a(
                        Yii::t('app', 'Вернуться к списку'),
                        ['/catalog/italian-product/list'],
                        ['class' => 'btn btn-cancel']
                    ) ?>

                </div>
            </div>
        </div>
    </div>
</main>