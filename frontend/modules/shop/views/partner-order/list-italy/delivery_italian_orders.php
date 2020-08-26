<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
use yii\widgets\Pjax;
use kartik\grid\GridView;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    ItalianProduct, Factory
};
use frontend\modules\shop\models\{Order, OrderAnswer, OrderItem, OrderItemPrice};

/**
 * @var $pages Pagination
 * @var $model ItalianProduct
 * @var $filter ItalianProduct
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="largex-container itprod-box">
            <div class="row title-cont">
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>
            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="cont-area cont-goods">

                            <?= GridView::widget([
                                'id' => 'italian-product-grid',
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Image link'),
                                        'value' => function ($model) {
                                            /** @var $model OrderItem */
                                            return Html::img(
                                                ItalianProduct::getImageThumb($model['product']['image_link']),
                                                ['width' => 200]
                                            );
                                        },
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Title'),
                                        'value' => function ($model) {
                                            /** @var $model OrderItem */
                                            return Html::a(
                                                $model['product']['title'],
                                                ItalianProduct::getUrl($model['product'][Yii::$app->languages->getDomainAlias()]),
                                                ['target' => '_blank']
                                            );
                                        },
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Answer time'),
                                        'value' => function ($model) {
                                            /** @var $model OrderItem */
                                            return date('d-m-Y', $model['order']['orderAnswer']['answer_time']);
                                        },
                                        'headerOptions' => ['class' => 'col-sm-2'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'filter' => false
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Стоимость доставки'),
                                        'value' => function ($model) {
                                            /** @var $model OrderItem */
                                            return $model['orderItemPrice']['price'];
                                        },
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Всего к оплате'),
                                        'value' => function ($model) {
                                            /** @var $model OrderItem */
                                            return $model->getDeliveryAmountForItalianProduct();
                                        },
                                    ],
                                    [
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            /** @var $model OrderItem */
                                            if ($model['product']['paymentDelivery']['payment_status'] == 'success') {
                                                return Yii::t('app', 'Оплачено');
                                            }

                                            $cost = $model->getDeliveryAmountForItalianProduct();
                                            $amount = $cost + ($cost * 0.02);
                                            $amount = Yii::$app->currency->getValue($amount, 'EUR', '');

                                            return Html::a(
                                                Yii::t('app', 'Оплатить'),
                                                ['/payment/payment/invoice'],
                                                [
                                                    'data-method' => 'POST',
                                                    'data-params' => [
                                                        '_csrf' => Yii::$app->getRequest()->getCsrfToken(),
                                                        'Payment[user_id]' => Yii::$app->user->id,
                                                        'Payment[type]' => 'italian_item_delivery',
                                                        'Payment[amount]' => $amount,
                                                        'Payment[currency]' => 'RUB',
                                                        'Payment[items_ids]' => $model['product']['id'],
                                                    ],
                                                    'class' => 'btn btn-goods'
                                                ]
                                            );
                                        },
                                    ],
                                ],
                            ]) ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
