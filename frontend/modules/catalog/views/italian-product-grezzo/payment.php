<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\modules\catalog\models\ItalianProduct;
use frontend\modules\payment\models\Payment;

$this->title = $this->context->title;

/** @var $modelPayment Payment */
/** @var $models ItalianProduct */
/** @var $product ItalianProduct */

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

                    <?php $form = ActiveForm::begin([
                        'action' => Url::toRoute(['/payment/payment/invoice'])
                    ]); ?>
                    <div class="wrap-table-totalpay">
                        <table class="table table-bordered table-totalpay">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th><?= Yii::t('app', 'Наименование услуг') ?></th>
                                <th><?= Yii::t('app', 'Количество') ?></th>
                                <th><?= Yii::t('app', 'Цена') ?></th>
                                <th><?= Yii::t('app', 'Валюта') ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($models as $key => $product) { ?>
                                <tr>
                                    <th><?= $key + 1 ?></th>
                                    <td class="cell-img-and-descr">
                                        <?= $product->getTitle() .
                                        Html::input(
                                            'hidden',
                                            'Payment[items_ids][]',
                                            $product->id
                                        ) .
                                        Html::img(
                                            ItalianProduct::getImageThumb($product['image_link']),
                                            ['width' => 200]
                                        ) ?>
                                    </td>
                                    <td>1</td>
                                    <td><?= $amount ?></td>
                                    <td><?= $modelPayment->currency ?></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="total-box">
                        <div>
                            <span class="for-total"><?= Yii::t('app', 'Итого') ?>:</span> <span
                                    class="for-styles"><?= $total . ' ' . $modelPayment->currency ?></span>
                        </div>
                        <div>
                            <span class="for-total"><?= Yii::t('app', 'В том числе НДС') ?> :</span> <span
                                    class="for-styles"><?= $nds . ' ' . $modelPayment->currency ?></span>
                        </div>
                        <?php if ($discount_percent) { ?>
                            <div>
                                <span class="for-total"><?= Yii::t('app', 'Скидка') . ' ' . $discount_percent . '%'; ?> :</span>
                                <span class="for-styles"><?= $discount_money . ' ' . $modelPayment->currency ?></span>
                            </div>
                        <?php } ?>
                        <div>
                            <span class="for-total"><?= Yii::t('app', 'Всего к оплате') ?> :</span> <span
                                    class="for-styles"><?= $modelPayment->amount . ' ' . $modelPayment->currency ?></span>
                        </div>
                    </div>

                    <?php
                    echo $form
                            ->field($modelPayment, 'amount')
                            ->label(false)
                            ->input('hidden') .
                        $form
                            ->field($modelPayment, 'user_id')
                            ->label(false)
                            ->input('hidden') .
                        $form
                            ->field($modelPayment, 'type')
                            ->label(false)
                            ->input('hidden') .
                        $form
                            ->field($modelPayment, 'change_tariff')
                            ->label(false)
                            ->input('hidden') .
                        $form
                            ->field($modelPayment, 'currency')
                            ->label(false)
                            ->input('hidden');

                    echo Html::tag(
                        'div',
                        Html::submitButton(
                            Yii::t('app', 'Перейти к оплате'),
                            ['class' => 'btn btn-goods']
                        ) . '&nbsp;' . Html::a(
                            Yii::t('app', 'Вернуться к списку'),
                            ['/catalog/italian-product-grezzo/list'],
                            ['class' => 'btn btn-cancel']
                        ),
                        ['class' => 'buttons-cont']
                    );

                    ActiveForm::end();
                    ?>

                </div>
            </div>
        </div>
    </div>
</main>
