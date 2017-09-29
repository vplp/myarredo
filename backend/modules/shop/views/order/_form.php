<?php
use thread\app\bootstrap\ActiveForm;
//
use thread\widgets\HtmlForm;

use backend\modules\{
    shop\models\DeliveryMethods, shop\models\PaymentMethods
};

/**
 * @var $model \backend\modules\shop\models\Order
 * @var $form \thread\app\bootstrap\ActiveForm
 */
?>

<p><?= Yii::t('app', 'User') . ': ' . $model['customer']['full_name'] ?? '' ?></p>
<p><?= Yii::t('app', 'Phone') . ': ' . $model['customer']['phone'] ?? '' ?></p>
<?php HtmlForm::showTextInput($model, 'items_total_count') ?>
<?php HtmlForm::showTextInput($model, 'discount_full') ?>
<?php HtmlForm::showTextInput($model, 'total_summ') ?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->field($model, 'order_status')->dropDownList($model::getOrderStatuses()) ?>
<?= $form->field($model, 'payment_method_id')->dropDownList(PaymentMethods::dropDownList()) ?>
<?= $form->field($model, 'payd_status')->dropDownList($model::getPaidStatuses()) ?>
<?= $form->field($model, 'delivery_method_id')->dropDownList(DeliveryMethods::dropDownList()) ?>
<?= $form->text_line($model, 'delivery_price') ?>
<?= $form->text_line($model, 'comment')->textarea(['style' => 'height:100px;', 'value' => ' ']) ?>
<?= $form->submit($model, $this) ?>
<?= $this->render('parts/_items_list', ['model' => $model]) ?>


<?php ActiveForm::end();
