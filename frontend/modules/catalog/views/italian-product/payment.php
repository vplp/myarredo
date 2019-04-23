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

                    <table class="table table-bordered">
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
                                <td>
                                    <?= $product->getTitle() .
                                    Html::input(
                                        'hidden',
                                        'Payment[items_ids][]',
                                        $product->id
                                    ) .
                                    Html::img(
                                        ItalianProduct::getImageThumb($product['image_link']),
                                        ['width' => 50]
                                    ) ?>
                                </td>
                                <td>1</td>
                                <td><?= $amount ?></td>
                                <td><?= $modelPayment->currency ?></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>

                    <div>
                        <?= Yii::t('app', 'Итого') ?>: <?= $modelPayment->amount . ' ' . $modelPayment->currency ?>
                    </div>
                    <div>
                        <?= Yii::t('app', 'В том числе НДС') ?>
                        : <?= '0 ' . $modelPayment->currency ?>
                    </div>
                    <div>
                        <?= Yii::t('app', 'Всего к оплате') ?>
                        : <?= $modelPayment->amount . ' ' . $modelPayment->currency ?>
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
                            ['/catalog/italian-product/list'],
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