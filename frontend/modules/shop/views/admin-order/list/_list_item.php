<?php

use yii\helpers\{
    Html, Url
};
use yii\bootstrap\Modal;
use backend\app\bootstrap\ActiveForm;
use frontend\modules\shop\models\{
    Order, OrderItem, OrderAnswer
};
use frontend\modules\catalog\models\{
    Product, Factory
};

/* @var $this yii\web\View */
/* @var $modelOrder Order */
/* @var $modelOrderAnswer OrderAnswer */
/* @var $orderItem OrderItem */

?>

<?php 
if (in_array(Yii::$app->user->identity->group->role, ['admin']) || (in_array(Yii::$app->user->identity->group->role, ['partner', 'factory', 'settlementCenter']) && Yii::$app->user->identity->profile->getPossibilityToAnswer($modelOrder))) {
    $form = ActiveForm::begin([
        'options' => ['data' => ['pjax' => true]],
        'action' => $modelOrder->getPartnerOrderOnListUrl(),
    ]); ?>

    <div class="hidden-order-in ordersanswer-box">
        <div class="flex-product orderanswer-cont">

            <?php if ($modelOrder->items) {
                foreach ($modelOrder->items as $orderItem) {
                    if (isset($orderItem->product)) { ?>
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
                                    <td colspan="2">
                                        <?= Html::a(
                                            $orderItem->product->getTitle(),
                                            Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()])
                                        ); ?>
                                    </td>
                                </tr>

                                <?php if (isset($orderItem->product['is_composition']) && !$orderItem->product['is_composition']) { ?>
                                    <tr>
                                        <td colspan="2" class="spec-pad">
                                    <span class="for-ordertable">
                                        <?= Yii::t('app', 'Артикул') ?>
                                    </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="spec-pad2">
                                            <?= $orderItem->product['article'] ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr class="noborder">
                                    <td colspan="2" class="spec-pad">
                                    <span class="for-ordertable">
                                        <?= Yii::t('app', 'Factory') ?>
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="spec-pad2">
                                        <?php if (isset($orderItem->product['factory']['lang']) && $orderItem->product['factory']['title']) {
                                            echo Html::a(
                                                $orderItem->product['factory']['title'],
                                                Factory::getUrl($orderItem->product['factory']['alias'])
                                            );
                                        } ?>
                                        <br>
                                        <?php
                                        if (isset($orderItem->product['factory']['alias'])) {
                                            echo Html::a(
                                                Yii::t('app', 'Условия работы'),
                                                ['/catalog/factory/view-tab', 'alias' => $orderItem->product['factory']['alias'], 'tab' => 'working-conditions'],
                                                ['target' => '_blank']
                                            );
                                        } ?>

                                    </td>
                                </tr>
                                <tr class="noborder">
                                    <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Цена для клиента') ?>
                                </span>
                                    </td>
                                </tr>
                                <tr class="orderlist-price-tr">
                                    <td colspan="2">
                                        <?php
                                        foreach ($orderItem->orderItemPrices as $price) {
                                            if ($answer->user_id != Yii::$app->user->id && !in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter'])) continue;
                                            if (in_array(Yii::$app->user->identity->group->role, ['settlementCenter']) && !((bool) Yii::$app->user->identity->profile->can_see_all_answers)) continue;
                                            echo '<div><strong>' . $price['user']['profile']->getNameCompany() . '</strong></div>' .
                                                '<div>' . $price['user']['email'] . '</div>' .
                                                '<div><strong>' . ($price['out_of_production'] == '1'
                                                    ? Yii::t('app', 'Снят с производства')
                                                    : $price['price'] . ' ' . $price['currency']) . '</strong></div><br>';
                                        }
                                        ?>

                                        <?= $form
                                            ->field($orderItem->orderItemPrice, 'product_id')
                                            ->input('hidden', [
                                                'name' => 'OrderItemPrice[' . $orderItem->product_id . '][product_id]',
                                                'class' => 'order-productid-hfield'
                                            ])
                                            ->label(false);
                                        ?>
                                        <div class="form-twoboxl">
                                            <?= $form
                                                ->field($orderItem->orderItemPrice, 'price')
                                                ->input('text', [
                                                    'name' => 'OrderItemPrice[' . $orderItem->product_id . '][price]',
                                                    'value' => $orderItem->orderItemPrice->price ?? 0,
                                                    'disabled' => ($modelOrder->orderAnswer->answer_time == 0) ? false : true,
                                                    'class' => 'orderlist-price-field'
                                                ])
                                                ->label(false);
                                            ?>
                                            <?= $form
                                                ->field(
                                                    $orderItem->orderItemPrice,
                                                    'currency'
                                                )
                                                ->dropDownList($orderItem->orderItemPrice::currencyRange(), ['name' => 'OrderItemPrice[' . $orderItem->product_id . '][currency]'])
                                                ->label(false)
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="order-list-td">
                                        <?= $form
                                            ->field($orderItem->orderItemPrice, 'out_of_production')
                                            ->checkbox([
                                                'id' => 'orderitemprice-out_of_production' . $orderItem->id,
                                                'name' => 'OrderItemPrice[' . $orderItem->product_id . '][out_of_production]',
                                                'disabled' => ($modelOrder->orderAnswer->answer_time == 0) ? false : true,
                                                'class' => 'field-orderitemprice-out_of_production outof-prod-checkbox'
                                            ], false);
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
                                ?>

                                <p class="title-small"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
                                <ul class="pricelist">
                                    <?php
                                    if (!empty($pricesFiles)) {
                                        foreach ($pricesFiles as $priceFile) {
                                            if ($fileLink = $priceFile->getFileLink()) { ?>
                                                <li>
                                                    <?= Html::a(
                                                        $priceFile->title,
                                                        Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink . '&search=' . $orderItem->product->article,
                                                        [
                                                            'target' => '_blank',
                                                            'class' => 'click-on-factory-file',
                                                            'data-id' => $priceFile->id,
                                                            'data-factory' => $priceFile->factory_id
                                                        ]
                                                    ) ?>
                                                </li>
                                            <?php }
                                        }
                                    } else { ?>
                                        <li>
                                            <?php if (isset($orderItem->product['factory']['lang']) && $orderItem->product['factory']['title']) {
                                                echo Html::a(
                                                    Yii::t('app', 'Прайс листы') . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                                                    ['/catalog/factory/view-tab', 'alias' => $orderItem->product['factory']['alias'], 'tab' => 'pricelists'],
                                                    [
                                                        'target' => '_blank',
                                                        'class' => 'btn-inpdf'
                                                    ]
                                                );
                                            } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                    <?php }
                }
            } else {
                echo Yii::t('app', 'Клиент оставил данную заявку, так как не нашел то что искал на сайте.');
            } ?>

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

                <?= $form->field($modelOrder, 'comment')
                    ->textarea(['rows' => 5, 'disabled' => true]) ?>

                <?php foreach ($modelOrder->orderAnswers as $answer) {
                    if ($answer->user_id != Yii::$app->user->id && !in_array(Yii::$app->user->identity->group->role, ['admin', 'settlementCenter'])) continue;
                    if (in_array(Yii::$app->user->identity->group->role, ['settlementCenter']) && !((bool) Yii::$app->user->identity->profile->can_see_all_answers)) continue;
                    echo '<div><strong>' . $answer['user']['profile']->getNameCompany() . '</strong></div>' .
                        '<div>' . $answer['user']['email'] . '</div>' .
                        '<div>' . $answer->getAnswerTime() . '</div>' .
                        '<div>' . $answer['answer'] . '</div><br>';
                } ?>

                <?= $form
                    ->field($modelOrder, 'admin_comment')
                    ->textarea(['rows' => 5]); ?>

                <?= $form
                    ->field($modelOrderAnswer, 'answer')
                    ->textarea([
                        'rows' => 5,
                        'disabled' => (!$modelOrderAnswer->id || $modelOrderAnswer->answer_time == 0) ? false : true
                    ]) ?>

                <?= $form
                    ->field($modelOrderAnswer, 'id')
                    ->input('hidden')
                    ->label(false) ?>

                <?= $form
                    ->field($modelOrderAnswer, 'order_id')
                    ->input('hidden', ['value' => $modelOrder->id])
                    ->label(false) ?>

                <?php if(!empty($modelOrderAnswer->file)) {?>
                    <div class="form-group field-orderanswer-file">
                        <label class="control-label" for="orderanswer-file">Прикрепленный файл</label>
                        <div>
                            <?= Html::a(
                                $modelOrderAnswer->file,
                                '/uploads/files/'.$modelOrderAnswer->file,
                                ['target' => '_blank']
                            ); ?>
                        </div>
                    </div>
                <?php } elseif (empty($modelOrderAnswer->answer)) { ?>
                    <?= $form->field($modelOrderAnswer, 'file')->fileInputWidgetShort($modelOrderAnswer->getFile());?>
                <?php } ?>

                <?php if ($modelOrder->order_count_url_visit) {
                    echo '<div>'.Yii::t('app', 'Просмотреных страниц').': ' . $modelOrder->order_count_url_visit . ' ' . ($modelOrder->order_mobile ? Yii::t('app', 'мобильный') : Yii::t('app', 'ПК')) . '</div>' .
                        '<div>'.Yii::t('app', 'Первая страница').': ' . Html::a(Yii::t('app', 'Ссылка'), $modelOrder->order_first_url_visit, ['target' => '_blank']) . '</div>';
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
<?php } else { ?>
    <div class="hidden-order-in">
        <div class="flex-product orderanswer-cont">

            <?php
            foreach ($modelOrder->items as $orderItem) {
                echo $this->render('_list_item_product_archive', [
                    'orderItem' => $orderItem,
                ]);
            } ?>

        </div>
        <div class="form-wrap">

        </div>
    </div>

<?php } ?>