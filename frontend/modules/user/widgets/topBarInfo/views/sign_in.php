<?php

use yii\helpers\Html;

?>

<?= Html::a(
    Yii::t('app', 'Sign In'),
    ['/user/login/index'],
    [
        'class' => 'btn btn-transparent sign-in'
    ]
); ?>