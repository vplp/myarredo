<?php

use frontend\modules\forms\models\FeedbackForm;
use backend\themes\inspinia\widgets\forms\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;



?>

<p><?= Yii::t('app', 'Feedback form') ?></p>
<?php $modelCallBack = new FeedbackForm() ?>

<?php
$formCallBack = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'ajaxDataType' => true,
    'id' => 'feedback-form',
    'action' => '#'
]);
?>
<div class="collection clearfix">

    <?= $formCallBack->field($modelCallBack, 'name', ['inputOptions' => ['style' => '', 'placeholder'=>$modelCallBack->getAttributeLabel('name'),
        'class'=>'name' ]])->label(false); ?>

    <?= Html::error($modelCallBack, 'name',['class' => 'name-error errors']) ?>

    <?= $formCallBack->field($modelCallBack, 'phone', ['inputOptions' => ['style' => '', 'placeholder'=>$modelCallBack->getAttributeLabel('phone'),
        'class'=>'phone' ]])->label(false); ?>

    <?= Html::error($modelCallBack, 'phone',['class' => 'phone-error errors']); ?>

    <?= $formCallBack->field($modelCallBack, 'email', ['inputOptions' => ['style' => '', 'placeholder'=>$modelCallBack->getAttributeLabel('email'),
        'class'=>'email' ]])->label(false); ?>

    <?= Html::error($modelCallBack, 'email',['class' => 'email-error errors']); ?>

    <div class="select-style">
        <?= $formCallBack->field($modelCallBack, 'topic_id')->label('')->dropDownList($TopicDropdownList);
        ?>

    </div>
    <?= Html::error($modelCallBack, 'email',['class' => 'topic_id-error errors']); ?>

    <?= $formCallBack->field($modelCallBack, 'question', ['inputOptions' => ['style' => 'resize:none;', 'placeholder'=>$modelCallBack->getAttributeLabel('question'), 'class'=>'tarea' , 'rows'=>5, ]])->textarea()->label(false); ?>

    <?= Html::error($modelCallBack, 'question',['class' => 'question-error errors']); ?>

    <?= $formCallBack->field($modelCallBack, 'reCaptcha')->label('')->widget(
        \himiklab\yii2\recaptcha\ReCaptcha::className(),
        ['siteKey' => '6LffASYTAAAAAOzNPp76vwu77r5GLyMMLu1d11TQ']
    ) ?>







</div>
<!--<input type="submit" class="submit" value="Отправить">-->
<?= Html::submitButton('<b>'.Yii::t('form', 'send').'</b>', ['class' => 'submit']) ?>
<!-- <button type="submit" class="submit"><b>Отправить</b></button>-->
<?php $formCallBack->end();
?>
