<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\user\models\Profile $model
 */

$this->title = Yii::t('app', 'Profile');

?>

<main>
    <div class="page factory-profile">
        <div class="largex-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">
                <div class="part-contact-left">
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'phone') ?>
                        <?= $model['phone'] ?>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'first_name') ?>
                        <?= $model['first_name'] ?>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'last_name') ?>
                        <?= $model['last_name'] ?>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'email') ?>
                        <?= $model['user']['email'] ?>
                    </div>

                    <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'partner') { ?>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'name_company') ?>
                            <?= $model['name_company'] ?>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'website') ?>
                            <?= $model['website'] ?>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'address') ?>
                            <?= $model['address'] ?>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'country_id') ?>
                            <?= $model['country']['lang']['title'] ?>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'city_id') ?>
                            <?= $model['city']['lang']['title'] ?>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <?= Html::a(Yii::t('app', 'Edit'), ['/user/profile/update'], [
                            'class' => 'btn btn-info'
                        ]) ?>
                        <?= Html::a(Yii::t('user', 'Change password'), ['/user/password/change'], [
                            'class' => 'btn btn-success'
                        ]) ?>
                    </div>
                </div>
                <div class="part-contact-right">
                    <div class="welcome-box">
                        <div class="welcome-left">
                            <img src="http://www.myarredo.test/assets/20c53c30/img/thank_register.png" alt="welcome">
                        </div>
                        <div class="welcome-right">
                            <span class="welcome-tittle">
                                Поздравляем!
                            </span>
                            <span class="welcome-tittle">
                                Регистрация завершена успешно.
                            </span>
                            <span class="welcome-subtitle">
                                В ближайшее время с Вами свяжется наш менеджер.
                            </span>
                            <span class="welcome-desc">
                                С уважением <br/>
                                Команда MY ARREDO FAMILY
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
