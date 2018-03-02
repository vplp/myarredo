<?php

use yii\helpers\Html;
//
use backend\modules\location\models\{
    Country, City
};
use backend\modules\catalog\models\Factory;

/**
 * @var $model \backend\modules\user\models\Profile
 */

?>

<?= $form->text_line($model, 'first_name') ?>

<?= $form->text_line($model, 'last_name') ?>

<?= $form->text_line($model, 'phone') ?>

<?= $form->text_line($model, 'name_company') ?>

<?= $form->text_line($model, 'website') ?>

<?= $form->field($model, 'country_id')
    ->selectOne([0 => '--'] + Country::dropDownList()); ?>

<?= $form->field($model, 'city_id')
    ->selectOne([0 => '--'] + City::dropDownList($model->country_id)); ?>

<?= $form->field($model, 'factory_id')
    ->selectOne([0 => '--'] + Factory::dropDownList($model->factory_id)); ?>

<?= $form->text_line($model, 'latitude') ?>
<?= $form->text_line($model, 'longitude') ?>

<?= $form->text_line($model, 'address') ?>

<?= $form->field($model, 'preferred_language')->dropDownList(\Yii::$app->params['themes']['languages']); ?>

<?php //$form->field($model, 'avatar')->imageOne($model->getAvatarImage()) ?>

<?= Html::a(Yii::t('user', 'Change password'), ['/user/password/change', 'id' => $model['id']], ['class' => 'btn btn-info']); ?>

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