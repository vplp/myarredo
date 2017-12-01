<?php

use yii\helpers\Html;
//
use backend\app\bootstrap\ActiveForm;
use backend\modules\location\models\{
    Country, City
};
/**
 * @var \backend\modules\user\models\Profile $model
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>

<?= $form->text_line($model, 'first_name') ?>
<?= $form->text_line($model, 'last_name') ?>
<?= $form->text_line($model, 'phone') ?>

<?= $form->text_line($model, 'name_company') ?>
<?= $form->text_line($model, 'website') ?>

<?= $form->field($model, 'country_id')
    ->selectOne([null => '--'] + Country::dropDownList()); ?>

<?= $form->field($model, 'city_id')
    ->selectOne([null => '--'] + City::dropDownList($model->country_id)); ?>

<?= $form->text_line($model, 'latitude') ?>
<?= $form->text_line($model, 'longitude') ?>

<?= $form->text_line($model, 'address') ?>

<?= $form->field($model, 'preferred_language')->dropDownList(\Yii::$app->params['themes']['languages']); ?>

<?php //$form->field($model, 'avatar')->imageOne($model->getAvatarImage()) ?>

<?php if (in_array($model['user']['group_id'], [4])):
    echo $form->switcher($model, 'partner_in_city');
endif; ?>

<?= Html::a(Yii::t('user', 'Change password'), ['/user/password/change', 'id' => $model['id']], ['class' => 'btn btn-info']); ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end()?>

<?php
$url = \yii\helpers\Url::toRoute('/location/city/get-cities');

$script = <<<JS
$('select#profile-country_id').change(function(){
    var country_id = parseInt($(this).val());
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#profile-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});

JS;

$this->registerJs($script, yii\web\View::POS_READY);