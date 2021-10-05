<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\shop\models\Order;
use frontend\modules\news\widgets\news\NewsListForPartners;

/**
 * @var $modelOrder Order
 * @var $model Order
 * @var $models Order
 */

$this->title = $this->context->title;
?>


    <main>
        <div class="page adding-product-page ordersbox">
            <div class="largex-container">

                <?= Html::tag('h1', $this->context->title); ?>

                <?php if (in_array(Yii::$app->user->identity->group->role, ['partner'])) {
                    echo NewsListForPartners::widget([]);
                } ?>

                <?= $this->render('_form_filter', ['model' => $model,
                    'params' => $params,
                    'models' => $models,]); ?>

                <?php if (!Yii::$app->user->identity->profile->getPossibilityToAnswerSaleItaly()) {
                    if (DOMAIN_TYPE == 'com') {
                        $phone = '<a href="tel:+3904221500215">+39 (0422) 150-02-15</a>';
                    } else {
                        $phone = '';
                    }
                    ?>
                    <div class="info-alertbox">
                        <?= Yii::t('app', 'Для получения возможности ответов на заявки - свяжитесь с администратором сайта') . ' ' . $phone ?>
                    </div>
                <?php } ?>

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
                            <li>
                                <span><?= Yii::t('app', 'Дата ответа') ?></span>
                            </li>
                            <li class="lang-cell">
                                <span><?= Yii::t('app', 'lang') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'City') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'Status') ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="manager-history-list">

                        <?php foreach ($models->getModels() as $modelOrder) { ?>
                            <div class="item" data-hash="<?= $modelOrder->id; ?>">
                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span><?= $modelOrder->id ?></span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $modelOrder->getCreatedTime() ?></span>
                                    </li>
                                    <li>
                                        <span><?= $modelOrder->customer->full_name ?></span>
                                    </li>
                                    <li>
                                        <span>
                                            <?php if ($modelOrder->orderAnswer->id && $modelOrder->orderAnswer->answer_time != 0) {
                                                echo $modelOrder->customer->phone;
                                            } else {
                                                echo '-';
                                            } ?>
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            <?php if ($modelOrder->orderAnswer->id && $modelOrder->orderAnswer->answer_time != 0) {
                                                echo $modelOrder->customer->email;
                                            } else {
                                                echo '-';
                                            } ?>
                                        </span>
                                    </li>
                                    <li>
                                        <span><?= $modelOrder->orderAnswer->getAnswerTime() ?></span>
                                    </li>
                                    <li class="lang-cell">
                                        <span><?= substr($modelOrder->lang, 0, 2) ?></span>
                                    </li>
                                    <li>
                                        <span>
                                            <?= ($modelOrder->city) ? $modelOrder->city->getTitle() : ''; ?>
                                        </span>
                                    </li>
                                    <li><span class="order_status_<?= $modelOrder->order_status ?>"><?= Order::getOrderStatuses($modelOrder->order_status); ?></span></li>
                                </ul>

                                <div class="hidden-order-info flex">
                                    <?php
                                    if (!Yii::$app->user->identity->profile->getPossibilityToAnswerSaleItaly() || $modelOrder->isArchive()) {
                                        echo $this->render('_list_item_archive', ['modelOrder' => $modelOrder,]);
                                    } else {
                                        echo $this->render('_list_item', ['modelOrder' => $modelOrder,
                                            'modelOrderAnswer' => $modelOrder->orderAnswer,]);
                                    } ?>
                                </div>

                            </div>

                        <?php } ?>

                    </div>

                    <?= frontend\components\LinkPager::widget(['pagination' => $models->getPagination(),]) ?>

                </div>
            </div>
        </div>
    </main>

<?php

$url = Url::toRoute(['/shop/partner-order/pjax-save-order-answer']);
$messagePrice = Yii::t('app', 'Ваш ответ должен быть максимально приближен к реальности');

$script = <<<JS
$( ".manager-history-list" ).on( "click", ".action-save-answer", function() {
    var form = $(this).parent();
   
    // clear messages
    
    form
        .find('.field-orderanswer-answer')
        .removeClass('has-error')
        .find('.help-block')
        .text('');
    
   var isError = false;
       
    form.find('.basket-item-info').each(function (index, value) {
        var price = $(value).find('.field-orderitemprice-price');
        
        price.removeClass('has-error').find('.help-block').text('');
     
        // запускаем валидацию поля - цена
        if (parseFloat(price.find('#orderitemprice-price').val()) < 180) {
            price.addClass('has-error').find('.help-block').text('$messagePrice');
            isError = true;
        }
    });
    
    if (isError) {
        return false;
    }
     
    // send form
    
    $.post('$url', form.serialize()+'&action-save-answer=1').done(function (data) {
        if (data.OrderAnswer) {
            form
                .find('.field-orderanswer-answer')
                .addClass('has-error')
                .find('.help-block')
                .text(data.OrderAnswer.answer);
        }
        if (data.OrderItemPrice) {
            $.each(data.OrderItemPrice, function( product_id, error ) {
                form
                    .find('input[name="OrderItemPrice['+product_id+']"]')
                    .parent()
                    .addClass('has-error')
                    .find('.help-block').text(error.price);
            });
        }
        
        if (data.success == 1) {
            document.location.reload(true);
        }
            
    }, 'json');
      
    return false;
});
JS;

$this->registerJs($script);
