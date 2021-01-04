<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;

/**
 * @var \frontend\modules\user\models\form\RegisterForm $model
 */

$this->title = 'Регистрация';

?>

    <main>
        <div class="page sign-up-page">
            <div class="container large-container">
                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'action' => Url::toRoute('/user/register/index'),
                    'options' => ['class' => 'form-iti-validate']
                ]); ?>
                <div class="row">
                    <?= Html::tag('h2', $this->title); ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">


                        <?= $form->field($model, 'first_name') ?>

                        <?= $form->field($model, 'last_name') ?>

                        <?= $form->field($model, 'phone')
                            ->widget(\yii\widgets\MaskedInput::class, [
                                'mask' => Yii::$app->city->getPhoneMask(),
                                'clientOptions' => [
                                    'clearIncomplete' => true
                                ]
                            ]) ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

                        <div class="a-warning">
                            * поля обязательны для заполнения
                        </div>

                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>

                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-offset-2 col-sm-6 col-md-6 col-lg-5">

                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </main>

<?php
$url = Url::toRoute(['/location/location/get-cities']);
$script = <<<JS
$('select#registerform-country_id').change(function(){
    var country_id = parseInt($(this).val());
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#registerform-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});
JS;

$this->registerJs($script);
?>