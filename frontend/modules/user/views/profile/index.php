<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\user\models\Profile $model
 */

$this->title = 'Profile';

?>

<main>
    <div class="page sign-up-page">
        <div class="container large-container">

            <div class="row">
                <?= Html::tag('h2', $this->title); ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">

                    <div class="row form-group">
                        <div class="col-sm-12">
                            <?= Html::tag('h1', 'Profile') ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4">
                            <?= Html::activeLabel($model, 'first_name') ?>
                        </div>
                        <div class="col-sm-8">
                            <?= $model['first_name'] ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4">
                            <?= Html::activeLabel($model, 'last_name') ?>
                        </div>
                        <div class="col-sm-8">
                            <?= $model['last_name'] ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4">
                            <?= Html::a(Yii::t('app', 'Edit'), ['/user/profile/update'], [
                                'class' => 'btn btn-info'
                            ]) ?>
                        </div>
                        <div class="col-sm-8">
                            <?= Html::a(Yii::t('user', 'Change password'), ['/user/password/change'], [
                                'class' => 'btn btn-success'
                            ]) ?>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-6 col-lg-offset-2 col-sm-6 col-md-6 col-lg-5">

                </div>
            </div>

        </div>
    </div>
</main>
