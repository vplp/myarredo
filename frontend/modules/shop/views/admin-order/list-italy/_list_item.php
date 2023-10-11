<?php

use yii\helpers\{
    Html, Url
};
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use frontend\modules\shop\models\{
    Order, OrderItem, OrderAnswer
};
use frontend\modules\catalog\models\{
    ItalianProduct, Factory, Product
};

/* @var $this yii\web\View */
/* @var $modelOrder Order */
/* @var $modelOrderAnswer OrderAnswer */
/* @var $orderItem OrderItem */

?>

<?php $form = ActiveForm::begin([
    'id' => 'OrderAnswerForm',
    'options' => ['data' => ['pjax' => true]],
    'action' => $modelOrder->getPartnerOrderOnListUrl(),
]) ?>

<div class="hidden-order-in ordersanswer-box">
    <div class="flex-product orderanswer-cont">

        <?php foreach ($modelOrder->items as $orderItem) { ?>
            <?php if (empty($orderItem->product)) {
                $product = Product::findById($orderItem->product_id);
                if (empty($product)) {
                    continue;
                }
                $productClass = get_class($product);
                $published = (bool) $product['published'];
                
            } else {
                $published = ItalianProduct::isPublished($orderItem->product['alias']);
                $productClass = get_class($orderItem->product);
                $product = $orderItem->product;
            }
            ?>
            <div class="basket-item-info">
                <div class="img-cont">
                    <?php if ($published) {
                        echo Html::a(
                            Html::img($productClass::getImageThumb($product['image_link'])),
                            $productClass::getUrl($product[Yii::$app->languages->getDomainAlias()]),
                            ['target' => '_blank']
                        );
                    } else {
                        echo Html::img($productClass::getImageThumb($product['image_link']));
                    } ?>
                </div>
                <table class="char" width="100%">
                    <tr>
                        <td colspan="2">
                            <?php if ($published) {
                                echo Html::a(
                                    $product->getTitle(),
                                    $productClass::getUrl($product[Yii::$app->languages->getDomainAlias()]),
                                    ['class' => 'productlink']
                                );
                            } else {
                                echo $product->getTitle();
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Артикул') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $product['article'] ?>
                        </td>
                    </tr>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Предмет') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $product['types']['lang']['title'] ?>
                        </td>
                    </tr>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Factory') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?php if (isset($product['factory']['lang']) && isset($product['factory']['title'])) {
                                echo Html::a(
                                        $product['factory']['title'],
                                        Factory::getUrl($product['factory']['alias'])
                                    ) .
                                    '<br>' .
                                    Html::a(
                                        Yii::t('app', 'Условия работы'),
                                        ['/catalog/factory/view-tab', 'alias' => $product['factory']['alias'], 'tab' => 'working-conditions'],
                                        ['target' => '_blank']
                                    );
                            } else {
                                echo $product['factory_name'];
                            } ?>
                        </td>
                    </tr>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Region') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $product['region']['title'] ?? '' ?>
                        </td>
                    </tr>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= $product->getAttributeLabel('volume') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $product['volume'] ?>
                        </td>
                    </tr>
                    <?php if (isset($product['weight'])) { ?>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= $product->getAttributeLabel('weight') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $product['weight'] ?>
                        </td>
                    </tr>
                <?php } ?>
                    <?php if (!empty($product['specificationValue'])) { ?>
                        <tr class="noborder">
                            <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Размеры') ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="spec-pad2">
                                <?php
                                foreach ($product['specificationValue'] as $item) {
                                    if ($item['specification']['parent_id'] == 4 && $item['val']) {
                                        echo Html::beginTag('div') .
                                            $item['specification']['lang']['title'] .
                                            ' (' . Yii::t('app', 'см') . ')' .
                                            ': ' .
                                            $item['val'] .
                                            Html::endTag('div');
                                    }
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                            <span class="for-ordertable">
                                <?= Yii::t('app', 'Цена доставки') ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            foreach ($orderItem->orderItemPrices as $price) {
                                echo '<div><strong>' . $price['user']['profile']->getNameCompany() . '</strong></div>' .
                                    '<div>' . $price['user']['email'] . '</div>' .
                                    '<div><strong>' . ($price['out_of_production'] == '1' ? Yii::t('app', 'Снят с производства') : $price['price']) . '</strong></div><br>';
                            }
                            ?>

                            <?= $form
                                ->field($orderItem->orderItemPrice, 'product_id')
                                ->input('hidden', [
                                    'name' => 'OrderItemPrice[' . $product_id . '][product_id]',
                                ])
                                ->label(false);
                            ?>
                            <div class="form-twoboxl">
                                <?= $form
                                    ->field($orderItem->orderItemPrice, 'price')
                                    ->input('text', [
                                        'name' => 'OrderItemPrice[' . $product_id . '][price]',
                                        'value' => $orderItem->orderItemPrice->price ?? 0,
                                        'disabled' => ($modelOrder->orderAnswer->answer_time == 0) ? false : true
                                    ])
                                    ->label(false);
                                ?>
                                <?= $form
                                    ->field(
                                        $orderItem->orderItemPrice,
                                        'currency'
                                    )
                                    ->dropDownList($orderItem->orderItemPrice::currencyRange(), ['name' => 'OrderItemPrice[' . $product_id . '][currency]'])
                                    ->label(false);
                                ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        <?php } ?>

    </div>
    <div class="form-wrap">

        <div class="form-group">

            <?= $form->field($modelOrder, 'comment')
                ->textarea(['rows' => 5, 'disabled' => true]) ?>

            <?php if ($modelOrder->lang != 'ru-RU') {
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
            }

            foreach ($modelOrder->orderAnswers as $answer) {
                echo '<div><strong>' . $answer['user']['profile']->getNameCompany() . '</strong></div>' .
                    '<div>' . $answer['user']['email'] . '</div>' .
                    '<div>' . $answer->getAnswerTime() . '</div>' .
                    '<div>' . $answer['answer'] . '</div><br>';
            } ?>

            <?= $form
                ->field($modelOrderAnswer, 'answer')
                ->textarea(['rows' => 5,
                    'disabled' => (!$modelOrderAnswer->id || $modelOrderAnswer->answer_time == 0) ? false : true]) ?>

            <?= $form
                ->field($modelOrderAnswer, 'id')
                ->input('hidden')
                ->label(false) ?>

            <?= $form
                ->field($modelOrderAnswer, 'order_id')
                ->input('hidden', ['value' => $modelOrder->id])
                ->label(false) ?>

            <?php if ($modelOrder->orderAnswer->id && $modelOrder->orderAnswer->answer_time != 0) { ?>
                <div><strong><?= Yii::t('app', 'Контактные данные продавца') ?>:</strong></div>
                <?php foreach ($modelOrder->items as $orderItem) { ?>
                    <div><?= Yii::t('app', 'Phone') ?>: <?= $product['user']['profile']['phone'] ?></div>
                    <div>Email: <?= $product['user']['email'] ?></div>
                <?php } ?>
            <?php } ?>

            <?php if ($modelOrder->order_count_url_visit) {
                echo '<div>Просмотреных страниц: ' . $modelOrder->order_count_url_visit . ' ' . ($modelOrder->order_mobile ? 'мобильный' : 'ПК') . '</div>' .
                    '<div>Первая страница: ' . Html::a('Ссылка', $modelOrder->order_first_url_visit, ['target' => '_blank']) . '</div>';
            } ?>
        </div>

    </div>
</div>
<?php if (!$modelOrderAnswer->id && !$modelOrder->isArchive()) {
    echo Html::submitButton(
        Yii::t('app', 'Отправить ответ клиенту'),
        [
            'class' => 'btn btn-success action-save-answer',
            'name' => 'action-save-answer',
            'value' => 1
        ]
    );
} ?>
<?php ActiveForm::end(); ?>
