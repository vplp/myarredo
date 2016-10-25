<?php
/**
 * @author Alla Kuzmenko
 * @copyright (c) 2015, Thread
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use frontend\modules\shop\models\{
    DeliveryMethods, PaymentMethods
};


?>
<div class="block-title"><?= Yii::t('app', 'Ваши данные') ?></div>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute('/shop/cart/index'),
    'options' => ['class' => 'form-recall form-recall1'],
    'id' => 'contacts-form'
]); ?>
<?php

//TODO:: когда заработает регистрация добавить сюда заполнение пользовательских данных 

?>
<?= $form->field($model, 'full_name')->input('text',
    ['placeholder' => Yii::t('app', 'full_name'), 'value' => ''])->label(false) ?>
<?= $form->field($model, 'email')->input('text',
    ['placeholder' => Yii::t('app', 'email')])->label(false) ?>
<?= $form->field($model, 'phone')->input('text',
    ['placeholder' => Yii::t('app', 'phone')])->label(false) ?>

<?= $form->field($model, 'delivery')
    ->dropDownList(DeliveryMethods::dropDownList(), ['class' => ''])
    ->label(false) ?>

<?= $form->field($model, 'pay')
    ->dropDownList(PaymentMethods::dropDownList(), ['class' => 'g'])
    ->label(false) ?>

<?= $form->field($model, 'comment',
    ['options' => ['class' => '']])->textarea([
    'placeholder' => Yii::t('app', 'comment')
])->label(false) ?>

<button type="submit"><?= Yii::t('app', 'checkout'); ?></button>
<?php ActiveForm::end(); ?>

