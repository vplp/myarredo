<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\user\models\Profile $model
 */

$this->title = 'Профиль';

?>

<main>
    <div class="page factory-profile">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'name_company') ?>
                    <?= $model['name_company'] ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'address') ?>
                    <?= $model['address'] ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'country_id') ?>
                    <?= $model['country'] ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'city_id') ?>
                    <?= $model['city'] ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'phone') ?>
                    <?= $model['phone'] ?>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'website') ?>
                    <?= $model['website'] ?>
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
                <div class="form-group">
                    <?= Html::a(Yii::t('app', 'Edit'), ['/user/profile/update'], [
                        'class' => 'btn btn-info'
                    ]) ?>
                    <?= Html::a(Yii::t('user', 'Change password'), ['/user/password/change'], [
                        'class' => 'btn btn-success'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</main>
