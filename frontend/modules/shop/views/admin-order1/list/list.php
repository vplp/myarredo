<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
use frontend\modules\shop\models\Order;

/**
 * @var $pages Pagination
 * @var $modelOrder Order
 * @var $params array
 * @var $model array
 * @var $models array
 */

$this->title = $this->context->title;
?>
    <main>
        <div class="page adding-product-page">
            <div class="largex-container">

                <?= Html::tag('h1', $this->context->title); ?>

                <?= $this->render('_form_filter', [
                    'model' => $model,
                    'params' => $params,
                    'models' => $models,
                ]); ?>

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
                                <span><?= Yii::t('app', 'Дата ответа') ?></span>
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
                            <li class="lang-cell">
                                <span><?= Yii::t('app', 'lang') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'Country') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'City') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'Status') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('shop', 'Комментарий') ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="manager-history-list">

                        <?php foreach ($models->getModels() as $modelOrder) { ?>
                            <div class="item" data-hash="<?= $modelOrder->id; ?>">
                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span><?= $modelOrder->id; ?></span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $modelOrder->getCreatedTime() ?></span>
                                    </li>
                                    <li>
                                        <span <?= $modelOrder->getDiffAnswerTime('settlementCenter') > 2 ? 'style="color: red;"' : '' ?>>
                                            <?= $modelOrder->getFirstAnswerTime() ?>
                                        </span>
                                    </li>
                                    <li>
                                        <span><?= $modelOrder->customer->full_name ?></span>
                                    </li>
                                    <li>
                                        <span data-e="<? var_dump(Yii::$app->user->identity->profile->getPossibilityToViewCustomer($modelOrder))?>">
                                           <?php
                                           if (!Yii::$app->user->identity->profile->getPossibilityToViewCustomer($modelOrder)) {
                                               echo '-';
                                           } else {
                                               echo $modelOrder->customer->phone;
                                           } ?>
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                         <?php if (!Yii::$app->user->identity->profile->getPossibilityToViewCustomer($modelOrder)) {
                                             echo '-';
                                         } else {
                                             echo $modelOrder->customer->email;
                                         } ?>
                                        </span>
                                    </li>
                                    <li class="lang-cell">
                                        <span><?= substr($modelOrder->lang, 0, 2) ?></span>
                                    </li>
                                    <li>
                                        <span><?= ($modelOrder->country) ? $modelOrder->country->getTitle() : ''; ?></span>
                                    </li>
                                    <li>
                                        <span><?= $modelOrder->city_name ?? ($modelOrder->city ? $modelOrder->city->getTitle() : ''); ?></span>
                                    </li>
                                    <li>
                                        <span class="order_status_<?= $modelOrder->order_status ?>"><?= Order::getOrderStatuses($modelOrder->order_status); ?></span>
                                    </li>
                                    <li>
                                        <span>
                                            <?= Html::a(
                                                '<i class="fa fa-list" aria-hidden="true"></i>',
                                                Url::toRoute(['/shop/admin-order/manager', 'id' => $modelOrder->id])
                                            ) ?>

                                            <?php if ($modelOrder->orderComment && Yii::$app->user->identity->profile->getPossibilityToViewCustomer($modelOrder)) {
                                                echo Html::a(
                                                    date('j.m.Y H:i', $modelOrder->orderComment['updated_at']),
                                                    Url::toRoute(['/shop/admin-order/manager', 'id' => $modelOrder->id])
                                                );
                                            } ?>

                                        </span>
                                    </li>
                                </ul>

                                <div class="hidden-order-info flex">

                                    <?= $this->render('_list_item', [
                                        'modelOrder' => $modelOrder,
                                        'modelOrderAnswer' => $modelOrder->orderAnswer,
                                    ]) ?>

                                </div>
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


<?php
$url = Url::toRoute(['/shop/admin-order1/pjax-save-order-answer']);
$messagePrice = Yii::t('app', 'Ваш ответ должен быть максимально приближен к реальности');

$script = <<<JS

var errorIndicator = true;

// Запрет на ввод любых символов кроме точки.
$('.orderlist-price-field').on('keypress', function(e) {
    // разрешаем только цыфры с плавающей точкой
    if (isNaN(e.key) && e.key != '.') {
        e.preventDefault();
    }
});
// При фокусе убираем 0 у этого поля
$('.orderlist-price-field').on('focus', function() {
    var thisField = $(this);
    if (thisField.val() == '0') {
        thisField.val('');
    }
});
// При потере фокуса - если поле пустое - добавляем 0
$('.orderlist-price-field').on('blur', function() {
    var thisField = $(this);
    if (thisField.val() == '') {
        thisField.val('0');
    }
});

// Если произошел клик по кнопке - отправить ответ клиенту
$(".manager-history-list").on("click", ".action-save-answer", function() {
    var thisBtn = $(this);
    var form = thisBtn.parent('form');
    
    // clear messages
    form.find('.field-orderanswer-answer').removeClass('has-error');
    form.find('.help-block').text('');
    
    form.find('.basket-item-info').each(function (index, value) {
        var isError = false;
         
        var price = $(value).find('.field-orderitemprice-price');
        var out_of_production = $(value).find('input[type="checkbox"].outof-prod-checkbox').prop('checked');

        price.removeClass('has-error').find('.help-block').text('');
        
        // если не выбран чекбокс - Товар снят с производства
        if (!out_of_production) {
            // запускаем валидацию поля - цена
            if (parseFloat(price.find('.orderlist-price-field').val()) < 99) {
                price.addClass('has-error').find('.help-block').text('$messagePrice');
                isError = true;
            }
        }
        
        if (isError) {
            errorIndicator = false;
            return false;
        }
        else {
            errorIndicator = true;
        }
    });

    thisBtn.attr('disabled', true);
    thisBtn.append('<i class="fa fa-spinner fa-spin fa-fw"></i>');
    
    if (errorIndicator) {
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
                        .find('input[name="OrderItemPrice['+product_id+'][price]"]')
                        .parent()
                        .addClass('has-error')
                        .find('.help-block').text(error.price);
                });
            }
            
            if (data.success == 1) {
                document.location.reload(true);
            }
            else {
                thisBtn.attr('disabled', false); 
                thisBtn.children('i.fa').remove();
            }
        }, 'json');
    }
    else {
        thisBtn.attr('disabled', false); 
        thisBtn.children('i.fa').remove();
        return false;
    }
});

// Если происходит переключение именно чекбокса - Товар снят с производства
$(".manager-history-list").on('change', 'input[type="checkbox"].field-orderitemprice-out_of_production', function() {
    // и если этот чекбокс выбран
    if ($(this).prop('checked')) {
        // находим и отключаем поле - цена
        $(this).closest('tr').siblings('tr.orderlist-price-tr').find('input.orderlist-price-field').prop('disabled', true);
        // также прячем сообщение об ошибке в поле цена
        $(this).closest('tr').siblings('tr.orderlist-price-tr').find('.field-orderitemprice-price').find('.help-block').addClass('hidden');
    }
    else {
        // иначе включаем поле цена
        $(this).closest('tr').siblings('tr.orderlist-price-tr').find('input.orderlist-price-field').prop('disabled', false);
        // также убыраем скритие сообщения об ошибке в поле цены
        $(this).closest('tr').siblings('tr.orderlist-price-tr').find('.field-orderitemprice-price').find('.help-block').removeClass('hidden');
    }
});
JS;

$this->registerJs($script);
