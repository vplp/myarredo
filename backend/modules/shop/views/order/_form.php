<?php
use thread\app\bootstrap\ActiveForm;
//
use \backend\modules\shop\models\DeliveryMethods;
use \backend\modules\shop\models\PaymentMethods;
use thread\widgets\HtmlForm;

/**
 * @var $model \backend\modules\shop\models\Order
 * @var $form \thread\app\bootstrap\ActiveForm
 */
?>
    <div>
        <?php HtmlForm::showTextInput($model, 'manager_id') ?>
        <p><?= Yii::t('app', 'Customer') . ': ' . $model['customer']['full_name'] ?? '' ?></p>
        <?php HtmlForm::showTextInput($model, 'items_count') ?>
        <?php HtmlForm::showTextInput($model, 'items_total_count') ?>
        <?php HtmlForm::showTextInput($model, 'items_summ') ?>
        <?php HtmlForm::showTextInput($model, 'items_total_summ') ?>
        <?php HtmlForm::showTextInput($model, 'discount_percent') ?>
        <?php HtmlForm::showTextInput($model, 'discount_money') ?>
        <?php HtmlForm::showTextInput($model, 'discount_full') ?>
        <?php HtmlForm::showTextInput($model, 'total_summ') ?>
    </div>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line($model, 'manager_id') ?>
<?= $form->field($model, 'order_status')->dropDownList($model::progressRange()) ?>
<?= $form->field($model, 'payment_method_id')->dropDownList(PaymentMethods::dropDownList()) ?>
<?= $form->field($model, 'payd_status')->dropDownList($model::paydStatusRange()) ?>
<?= $form->field($model, 'delivery_method_id')->dropDownList(DeliveryMethods::dropDownList()) ?>
<?= $form->text_line($model, 'delivery_price') ?>
<?= $form->text_line($model, 'comment')->textarea(['style' => 'height:100px;']) ?>

<?= $this->render('parts/_items_list', ['model' => $model]) ?>


<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
