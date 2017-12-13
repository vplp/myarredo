<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
//
use frontend\modules\location\models\{
    Country, City
};

/**
 * @var \frontend\modules\user\models\form\RegisterForm $model
 */

$this->title = 'Регистрация партнера';
$model->delivery_to_other_cities = 1;

?>

    <main>
        <div class="page sign-up-page">
            <div class="container large-container">
                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'action' => Url::toRoute('/user/register/partner'),
                ]); ?>
                <div class="row">
                    <?= Html::tag('h2', $this->title); ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">

                        <?= $form->field($model, 'name_company') ?>

                        <?= $form->field($model, 'address') ?>

                        <?= $form->field($model, 'country_id')
                            ->dropDownList(
                                [null => '--'] + Country::dropDownList(),
                                ['class' => 'selectpicker']
                            ); ?>

                        <?= $form->field($model, 'city_id')
                            ->dropDownList(
                                [null => '--'] + City::dropDownList(),
                                ['class' => 'selectpicker']
                            ); ?>

                        <?= $form->field($model, 'phone')
                            ->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => Yii::$app->city->getPhoneMask(),
                                'clientOptions' => [
                                    'clearIncomplete' => true
                                ]
                            ]) ?>

                        <?= $form->field($model, 'website') ?>

                        <?= $form->field($model, 'first_name') ?>

                        <?= $form->field($model, 'last_name') ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

                        <?= $form->field($model, 'exp_with_italian') ?>

                        <?= $form->field($model, 'delivery_to_other_cities')->checkbox() ?>

                        <div class="a-warning">
                            * поля обязательны для заполнения
                        </div>

                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>

                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-offset-2 col-sm-6 col-md-6 col-lg-5">
                        <div class="text">
                            <p>
                                MyARREO FAMILY - это группа компаний, состоящая из лучших поставщиков итальянской мебели
                                на рынке СНГ. Мы объединились в единую сеть в 2013 году, и постоянно
                                пополняем ряды профессионалов в нашей сети на основании тщательного отбора.
                            </p>
                            <p>
                                Вам представляется уникальная возможность быть не просто пассивным пользователем
                                чужих электронных каталогов мебели, а стать непосредственным участником сети
                                профессиональных продавцов итальянской мебели по всей России и СНГ.
                            </p>
                            <p>
                                - вы получаете возможность работать как филиал большой сетевой компании,
                                имеющей свою стратегию развития и опыт построения успешного бизнеса.
                            </p>
                            <p>
                                - в вашем распоряжении огромный каталог мебели в котором более чем 270
                                фабрик и 60000 товаров с прайсовыми ценами, объемами и прочими характеристиками,
                                которые позволят оперативно посчитать цену для клиента.
                            </p>
                            <p>
                                - возможность разместить свои предметы экспозиции в разделе Распродажа.
                            </p>
                            <p>
                                - ежедневное получение запросов от реальных клиентов.
                            </p>
                            <p>
                                - особые условия и скидки от фабрик, логистических компаний и таможенных брокеров.
                            </p>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </main>

<?php

$script = <<<JS
    
    $('select#registerform-country_id').change(function(){
        var country_id = parseInt($(this).val());
        $.post('/location/location/get-cities', {_csrf: $('#token').val(),country_id:country_id}, function(data){
            var select = $('select#registerform-city_id');
            select.html(data.options);
            select.selectpicker("refresh");
        });
    });

JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>