<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\form\CreateForm $model
 */

$this->title = 'Регистрация партнера';

?>

<main>
    <div class="page sign-up-page">
        <div class="container large-container">
            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'action' => Url::toRoute('/user/register/index'),
            ]); ?>
                <div class="row">
                    <?= Html::tag('h2', $this->title); ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">



                        <div class="form-group">
                            <label>Название компании</label>
                            <input type="type" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Адресс*</label>
                            <input type="type" class="form-control" >
                        </div>

                        <div class="form-group select-form-group">
                            <label>Ваша страна*</label>
                            <select class="selectpicker">
                                <option>Украина</option>
                                <option>Мавритания</option>
                            </select>
                        </div>

                        <div class="form-group select-form-group">
                            <label>Ваш город*</label>
                            <select class="selectpicker">
                                <option>Киев</option>
                                <option>Чикаго</option>
                            </select>
                        </div>

                        <?= $form->field($model, 'phone')->label() ?>

                        <div class="form-group">
                            <label>Адресс сайта</label>
                            <input type="text" class="form-control" >
                        </div>

                        <?= $form->field($model, 'username')->label() ?>

                        <?= $form->field($model, 'email')->label() ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

                        <div class="form-group">
                            <label>Опыт работы с итальянской мебелью, лет</label>
                            <input type="text" class="form-control">
                        </div>


                        <div class="checkbox checkbox-primary">
                            <input id="checkbox1" type="checkbox" checked="">
                            <label for="checkbox1">
                                Готов к поставкам мебели в другие города
                            </label>
                        </div>

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