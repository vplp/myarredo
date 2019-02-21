<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\news\widgets\news\NewsListForPartners;

/**
 * @var \frontend\modules\shop\models\Order $modelOrder
 */

$this->title = $this->context->title;
?>

    <main>
        <div class="page adding-product-page ordersbox">
            <div class="largex-container">

                <?= Html::tag('h1', $this->context->title); ?>

                <?= NewsListForPartners::widget([]) ?>

                <?php if (!Yii::$app->user->identity->profile->possibilityToAnswer) { ?>
                    <div style="color:red; font-size: 24px;">
                        Вы сможете ответить на Заявки покупателей после размещения
                        небольшого кода на Вашем сайте.
                        <u>
                            <?= Html::a(
                                'Подробнее..',
                                Url::toRoute(['/page/page/view', 'alias' => 'razmeshchenie-koda']),
                                ['style' => 'color:red; font-size: 24px;']
                            ) ?>
                        </u>
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

                        <?php if (!empty($models)) { ?>
                            <?php foreach ($models as $modelOrder) { ?>
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
                                                <?php
                                                if ($modelOrder->orderAnswer->id &&
                                                    $modelOrder->orderAnswer->answer_time != 0) {
                                                    echo $modelOrder->customer->phone;
                                                } else {
                                                    echo '-';
                                                } ?>
                                            </span>
                                        </li>
                                        <li>
                                            <span>
                                                <?php
                                                if ($modelOrder->orderAnswer->id &&
                                                    $modelOrder->orderAnswer->answer_time != 0) {
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
                                            <?= ($modelOrder->city) ? $modelOrder->city->lang->title : ''; ?>
                                        </span>
                                        </li>
                                        <li><span><?= $modelOrder->getOrderStatus(); ?></span></li>
                                    </ul>

                                    <div class="hidden-order-info flex">
                                        <?php
                                        if ($modelOrder->isArchive()) {
                                            echo $this->render('_list_item_archive', [
                                                'modelOrder' => $modelOrder,
                                            ]);
                                        } else {
                                            echo $this->render('_list_item', [
                                                'modelOrder' => $modelOrder,
                                                'modelOrderAnswer' => $modelOrder->orderAnswer,
                                            ]);
                                        } ?>
                                    </div>

                                </div>

                            <?php } ?>
                        <?php } ?>

                    </div>

                    <?= frontend\components\LinkPager::widget([
                        'pagination' => $pages,
                    ]) ?>

                </div>
            </div>
        </div>
    </main>

<?php
if (Yii::$app->user->identity->profile->possibilityToAnswer) {
    $url = Url::toRoute(['/shop/partner-order/pjax-save']);

    $script = <<<JS
$( ".manager-history-list" ).on( "click", ".action-save-answer", function() {
    var form = $(this).parent();
   
    // clear messages
    
    form
        .find('.field-orderanswer-answer')
        .removeClass('has-error')
        .find('.help-block')
        .text('');
    
    form.find('.basket-item-info').each(function (index, value) {
        $(this)
            .find('.field-orderitemprice-price')
            .removeClass('has-error')
            .find('.help-block')
            .text('');
    });
    
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

    $this->registerJs($script, yii\web\View::POS_READY);
}