<?php

use kartik\widgets\Select2;
use backend\app\bootstrap\ActiveForm;
use backend\modules\shop\models\Order;
use backend\modules\user\models\User;

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


<?php
// Answers
foreach ($model->orderAnswers as $answer) {
    echo '<div><strong>' . $answer['user']['profile']['lang']['name_company'] . '</strong></div>' .
        '<div>' . $answer['user']['email'] . '</div>' .
        '<div>' . $answer->getAnswerTime() . '</div>' .
        '<div>' . $answer['answer'] . '</div><br>';
} ?>

<?= $form
    ->field($model, 'user_for_answer_ids')
    ->widget(Select2::class, [
        'data' => User::dropDownListPartner(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]);
?>

<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
