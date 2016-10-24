<br>
<br>
<?php echo \frontend\modules\shop\widgets\cart\Cart::widget(['view'=>'full']) ?>
<?= $this->render('customer-form', ['model' => $customerform]); ?>

