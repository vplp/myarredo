<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\shop\models\Order;

/**
 * @var $model Order
 * @var $form ActiveForm
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->cancel($model, $this) ?>

    <p><?= Yii::t('app', 'User') . ': ' . $model['customer']['full_name'] ?? '' ?></p>
    <p><?= Yii::t('app', 'Phone') . ': ' . $model['customer']['phone'] ?? '' ?></p>
    <p><?= Yii::t('app', 'Email') . ': ' . $model['customer']['email'] ?? '' ?></p>
    <p><?= Yii::t('app', 'City') . ': ' . ($model->city ? $model->city->getTitle() : '-') ?></p>

<?= $form
    ->text_line($model, 'comment')
    ->textarea(['column' => '5', 'disabled' => true]) ?>

<?= $this->render('parts/_product_list', ['model' => $model]) ?>

<?= $form->cancel($model, $this) ?>
<?php ActiveForm::end();
