<?php
use backend\app\bootstrap\ActiveForm;
//
use thread\widgets\HtmlForm;

use backend\modules\{
    shop\models\DeliveryMethods, shop\models\PaymentMethods
};

/**
 * @var $model \backend\modules\shop\models\Order
 * @var $form \backend\app\bootstrap\ActiveForm
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<p><?= Yii::t('app', 'User') . ': ' . $model['customer']['full_name'] ?? '' ?></p>
<p><?= Yii::t('app', 'Phone') . ': ' . $model['customer']['phone'] ?? '' ?></p>
<p><?= Yii::t('app', 'Email') . ': ' . $model['customer']['email'] ?? '' ?></p>
<p><?= Yii::t('app', 'City') . ': ' . $model->city->lang->title ?? '' ?></p>

<?php //HtmlForm::showTextInput($model, 'items_total_count') ?>
<?php //HtmlForm::showTextInput($model, 'discount_full') ?>
<?php //HtmlForm::showTextInput($model, 'total_summ') ?>


<?php //$form->field($model, 'order_status')->dropDownList($model::getOrderStatuses()) ?>
<?php //$form->field($model, 'payment_method_id')->dropDownList(PaymentMethods::dropDownList()) ?>
<?php //$form->field($model, 'payd_status')->dropDownList($model::getPaidStatuses()) ?>
<?php //$form->field($model, 'delivery_method_id')->dropDownList(DeliveryMethods::dropDownList()) ?>
<?php //$form->text_line($model, 'delivery_price') ?>
<?= $form->text_line($model, 'comment')->textarea(['style' => 'height:100px;', 'value' => ' ']) ?>


<?= $this->render('parts/_items_list', ['model' => $model]) ?>

<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
